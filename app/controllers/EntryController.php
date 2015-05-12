<?php

class EntryController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show form for entry creating and 
     * proccess for create new Entry.
     *
     * @return Response
     */
    public function create() {
        //response var for request Ajax
        $response = array("success" => false, "entry" => null, "message" => "", "callbak" => "");

        //Create validator for User registration form with all data sended. Load from model
        $validator = Validator::make(Input::all(), Entry::$rules_validator);

        //Only if request is send by form (post) procces to create user
        if (Request::isMethod('post')) {
            //Check fields data sended
            if ($validator->fails()) {
                //Redirecto to form with error
                $messages = $validator->messages()->all("<li>:message</li>");
                $error = "<ul>" . implode("", $messages) . "</ul>";

                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = $error;
                    return  Response::json($response);
                }

                return Redirect::to('/entry/new')->with('error', $error)->withInput(Input::all());
            }
            
            $data = Input::all();
            //Set user logged with owner
            $data["user_id"] = Auth::user()->id;
            
            //Pass validator, proccess to create User
            if ($entry = Entry::_save($data)) {
                //Response json format via ajax
                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = "Entry <em>'" . $entry->title . "'</em> created succesfull!!";
                    $response["success"] = true;
                    $response["entry"] = $entry;
                    $response["callback"] = "";
                    return  Response::json($response);
                }

                //Redirecto to home
                return Redirect::action('HomeController@index')->with('notice', "Entry <em>'" . $entry->title . "'</em> created succesfull!!");
            } else {
                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = 'Error creating entry. Please try again.';
                    return  Response::json($response);
                }
                //Error to try create User, redirecto to Registration form
                return Redirect::to('/entry/new')->with('error', 'Error creating entry. Please try again.')->withInput(Input::all());
            }
        }


        return View::make('entry.new');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function read($id) {
        //Get entry from database
        $entry = Entry::find($id);
        
        //Check if entry exist
        if(!$entry instanceof Entry){
            return Redirect::to('/')->with('error', trans("app.no_exist_entry") );
        }
        
        return View::make('entry.view')->with("entry",$entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
        //response var for request Ajax
        $response = array("success" => false, "entry" => null, "message" => "", "callbak" => "");

        //Get entry from database
        $entry = Entry::find($id);
        
        //Check if entry exist
        if(!$entry instanceof Entry){
            if (Request::ajax()) {
                //Response json format
                $response["message"] =  trans("app.no_exist_entry");
                return  Response::json($response);
            }
            return Redirect::to('/')->with('error', trans("app.no_exist_entry") );
        }
        
        //Get user owner for this entry
        $owner = $entry->user;
        //Check if user logged is owner for this entry, redirect to home
        if ($owner->id != Auth::user()->id) {
            if (Request::ajax()) {
                //Response json format
                $response["message"] =  trans("app.no_owner_message");
                return  Response::json($response);
            }
            return Redirect::to('/')->with('warning', trans("app.no_owner_message") );
        }

        //Create validator for User registration form with all data sended. Load from model
        $validator = Validator::make(Input::all(), Entry::$rules_validator);

        //Only if request is send by form (post) procces to create user
        if (Request::isMethod('post')) {
            //Check fields data sended
            if ($validator->fails()) {
                //Redirecto to form with error
                $messages = $validator->messages()->all("<li>:message</li>");
                $error = "<ul>" . implode("", $messages) . "</ul>";

                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = $error;
                    return  Response::json($response);
                }

                return Redirect::action("EntryController@update",array("id"=>$entry->id) )->with('error', $error)->withInput(Input::all());
            }
            
            //fill new data in entry
            $entry->title = Input::get("title");
            $entry->content = Input::get("content");
            $entry->tags = Input::get("tags");
            
            //Pass validator, proccess to update entry
            if ($entry = Entry::_save($entry)) {
                //Response json format via ajax
                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = "Entry <em>'" . $entry->title . "'</em> updated succesfull!!";
                    $response["success"] = true;
                    $response["entry"] = $entry;
                    $response["callback"] = "";
                    return  Response::json($response);
                }

                //Redirecto to home
                return Redirect::action('HomeController@index')->with('notice', "Entry <em>'" . $entry->title . "'</em> updated succesfull!!");
            } else {
                if (Request::ajax()) {
                    //Response json format
                    $response["message"] = 'Error updating entry. Please try again.';
                    return  Response::json($response);
                }
                //Error to try create User, redirecto to Registration form
                return Redirect::action("EntryController@update",array("id"=>$entry->id) )->with('error', 'Error updating entry. Please try again.')->withInput(Input::all());
            }
        }


        return View::make('entry.edit')->with("entry",$entry);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id) {
        //
    }

}
