<?php
/**
 * Description of Tweet
 *
 * @author erick
 */
class Tweet extends Eloquent {

    //Table name
    protected $table = 'twitter_entries';

    /**
     * The attributes from database table.
     *
     * @var array
     */
    protected $fillable = array('tw_id', 'tw_text','tw_name','tw_screen_name','tw_created_at','tw_profile_image_url','', 'user_id', 'is_hidden', 'time_hidden', 'time_created');
    
    //Disable timestamps 
    public $timestamps = false;

    /**
     * Define relationship for users
     **/
    public function user() {
        return $this->belongsTo('User', 'user_id', 'id');
    }
    
    /**
     * Check if entry owner is the same to user logged
     * @return boolean
     */
    
    public function is_owner(){
        if( Auth::guest() ){
            return false;
        }
        if ( $this->user_id != Auth::user()->id ){
            return false;
        }
        
        return true;
    }

    
    /**
     * Get all tweets with user relationship
     * Improved query performance of the relationship. 
     * 
     * @param int $page entries by page number
     * @return array Array of entries
     */
    public static function get_with_author($page){
        return Tweet::with("user")->orderBy('time_created','desc')->paginate($page);
    }
    
}
