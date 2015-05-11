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
                return Response::make('User profile to try access, dont existe', 401);
            }
            return Redirect::to('/')->with('error', trans("app.user_no_exist"));
        }
        
        $entries = $user->entries()->paginate(3);
        
        //Response view with ajax
        if (Request::ajax()) {
            return View::make('entry.list')->with("entries",$entries);
        }
        
        return View::make('user.profile')->with("user",$user)->with("entries",$entries);
    }

}
