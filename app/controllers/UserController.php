<?php

class UserController extends \BaseController {

    /**
     * Display a login form for user
     *
     * @return Response
     */
    public function showLogin() {
        return View::make('user.login');
    }

    /**
     * Procces data login for user
     *
     * @return Response
     */
    public function doLogin() {
        //Make validation for login
        $validator = Validator::make(Input::all(), array(
                    'username' => 'required|alphaNum|min:2',
                    'password' => 'required|alphaNum|min:4'
        ));
        //Check validation for login form
        if ($validator->fails()) {
            //Get all error message array
            $messages = $validator->messages()->all("<li>:message</li>");
            //Convert all error in a String (HTML list)
            $error = "<ul>".  implode("", $messages)."</ul>";
            //Redirecto to login with error
            return Redirect::to('/user/login')->with('error', $error)->withInput(array("username"=>Input::get('username')));
        } else {
            //Get data from form
            $data = array("username" => Input::get("username"), "password" => Input::get("password"));
            //Try login
            if (Auth::attempt($data)) {
                //If login is correct, redirecto to user's profile
                return Redirect::intended(action('UserController@profile', array('username' => Auth::user()->username )));
            } else {
                //Username or password incorrect, redirecto to login form
                return Redirect::to('/user/login')->with('error', trans('app.error_signin') )->withInput(array("username"=>Input::get('username')));
            }
        }
    }

    /**
     * Destroy session for user
     *
     * @return Response
     */
    public function logout() {
        //Logout user
        Auth::logout();
        //Destroy session
        Session::flush();
        //Redirect to home
        return Redirect::to('/');
    }

    /**
     *  Function for display registration user form and 
     *  Procces to create one.
     * 
     * @return Response
     */
    public function create() {

        //Create validator for User registration form with all data sended. Load from model
        $validator = Validator::make(Input::all(), User::$rules_validator);
        
        //Only if request is send by form (post) procces to create user
        if (Request::isMethod('post')) {
            
            //Check fields data sended
            if ($validator->fails()) {
                //Redirecto to form with error
                $messages = $validator->messages()->all("<li>:message</li>");
                $error = "<ul>".  implode("", $messages)."</ul>";
                return Redirect::to('/user/register')->with('error', $error)->withInput(Input::all());
            }
            
            //Pass validator, proccess to create User
            if( $user = User::_save( Input::all() ) ){
                //Auto login user created, is same that attemd method
                Auth::login($user);
                //Redirecto to profile
                return Redirect::intended(action('UserController@profile', array('username' => Auth::user()->username )))->with('notice', trans("app.welcome_message", array("user"=>Auth::user()->username) ));
            }else{
                //Error to try create User, redirecto to Registration form
                return Redirect::to('/user/register')->with('error', trans("app.error_creating"))->withInput(Input::all());
            }
        }
        
        //Return to view
        return View::make('user.register');
    }

    /**
     * Show the user profile
     *
     * @param  string $username
     * @return Response
     */
    public function profile($username) {
        
        $user = User::where("username","=",$username)->first();
        if( !$user instanceof User){
            if (Request::ajax()) {
                return Response::make(trans("app.user_no_exist"), 401);
            }
            return Redirect::to('/')->with('error', trans("app.user_no_exist"));
        }
        
        $entries = $user->entries()->paginate(3);
        
        if( Input::get("page") > $entries->getLastPage() ){
            return Response::make("Page no valid!!");
        }
        
        //Response view with ajax
        if (Request::ajax()) {
            return View::make('entry.list')->with("entries",$entries);
        }
        
        return View::make('user.profile')->with("user",$user)->with("entries",$entries);
    }
    /**
     * 
     */
    public function getTwitterTimeline($username){
        $perpage = 5;
        //Define response array
        $response = array(
            "success" => false,
            "message" => "",
            "data"=>array()
        );
        
        $user = User::where("username","=",$username)->first();
        
        //Checking if user exist in database
        if( !$user instanceof User){
            $response["message"] =trans("app.user_no_exist");
            return Response::json($response);
        }

        //Is no owner, can't view hidden tweets

        if (!Auth::guest() && Auth::user()->id != $user->id) {
            $tweets = $user->get_tweets($perpage, true)->toArray();
        } else {
            $tweets = $user->get_tweets($perpage)->toArray();
        }
        
        

        $response["message"] = trans("app.loaded_tweets",array("count"=>count($tweets["data"] )));
        $response["success"] = true;
        $response["data"] = $tweets;
        return Response::json($response);
    }
    
    public function toggle_tweet(){
        //Get id from view
        $twid = Input::get("twid");
        
        //Define response array
        $response = array(
            "success" => false,
            "message" => "",
            "data"=>array()
        );
        
        $tweet = Tweet::find($twid);
        
        //Checking if tweet exist in database
        if( !$tweet instanceof Tweet){
            $response["message"] =trans("app.tweet_no_exist");
            return Response::json($response);
        }
        
        if( Auth::user()->id != $tweet->user_id ){
            $response["message"] =  trans("app.no_owner_tweet");
            return Response::json($response);
        }
                
        //toggle flag hidden
        if( $tweet->is_hidden ){
            $tweet->is_hidden = 0;
            $response["message"] =  trans("app.tweet_show");
        }else{
            $tweet->is_hidden = 1;
            $response["message"] =  trans("app.tweet_hide");
        }
        $tweet->save();
        
        //Set and return object
        
        $response["success"] = true;
        $response["data"] = $tweet->toArray();
        return Response::json($response);
    }
    
    
    /**
     * 
     */
    public function syncTwitterTimeLine($username,$count){
        //Define response array
        $response = array(
            "success" => false,
            "message" => "",
            "data"=>array()
        );
        
        $user = User::where("username","=",$username)->first();
        //Checking if user exist in database
        if( !$user instanceof User){
            $response["message"] =  trans("app.user_no_exist");
            return Response::json($response);
        }
        
        //Api rest user_timeline parameters
        $parameters = array(
            'screen_name' => substr($user->twitter_account, 1),
            'count' => $count
        );
        
        //Get last tweet from database for syncronization
        $last_tweet = $user->get_last_tweet();
        if( $last_tweet ){
            //Append parameter since
            $parameters['since_id'] = $last_tweet->tw_id;
        }
        
        
        //Get form Twitter API, the last tweet since local tweet saved.
        try {
            $tweets = Twitter::getUserTimeline($parameters);
        } catch (Exception $e) {
            $response["message"] = $e->getMessage();
            return Response::json($response);
        }

        //If have new tweets, add in database
        if( count($tweets )){
            foreach($tweets as $tweet){
                $tweet_entry = new Tweet;
                $tweet_entry->tw_id = $tweet->id_str;
                $tweet_entry->tw_text = $tweet->text;
                $tweet_entry->tw_name = $tweet->user->name;
                $tweet_entry->tw_screen_name = $tweet->user->screen_name;
                $tweet_entry->tw_profile_image_url = $tweet->user->profile_image_url;
                $tweet_entry->tw_created_at = strtotime($tweet->created_at);
                $tweet_entry->user_id = $user->id;
                $tweet_entry->is_hidden = 0;
                $tweet_entry->time_created = \time();
                $tweet_entry->save();
                
                $response["data"][$tweet_entry->tw_id] = $tweet_entry->toArray();
            }
        }
        
        ksort($response["data"]);
        
        //Return JSON response with new new tweet, for display
        $response["message"] = trans("app.loaded_new_tweets",array("count"=>count($tweets )));
        $response["total"] = count($tweets);
        $response["success"] = true;
        return Response::json($response);
    }

}
