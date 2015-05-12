<?php

class HomeController extends BaseController {
  
    /** 
     * Build index page for blog. Display all entries with users.
     * @return Response
     **/
    public function index() {
        
        //Get all entries 
        $entries = Entry::get_with_author(3);
        
        if( Input::get("page") > $entries->getLastPage() ){
            return Response::make("Page no valid!!");
        }
        
        //Get all users
        $users = User::get_with_entries();
        
        //Response view with ajax
        if (Request::ajax()) {
            return View::make('entry.list')->with("entries",$entries);
        }
        
        //Make home view
        return View::make('blog.index')->with("entries",$entries)->with("users",$users);
    }

}
