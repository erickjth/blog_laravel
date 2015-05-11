<?php
/**
 * Description of Entry
 *
 * @author erick
 */
class Entry extends Eloquent {

    //Table name
    protected $table = 'entries';

    /**
     * The attributes from database table.
     *
     * @var array
     */
    protected $fillable = array('title', 'content', 'tags', 'user_id', 'time_created', 'time_updated');
    //Disable timestamps 
    public $timestamps = false;
    //Array of rules form by this model
    public static $rules_validator = array(
        'title' => 'required|min:2',
        'content' => 'required',
    );

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
     * Convert string tagas to array
     * @return array
     */
    public function get_tags_array(){
        if( empty($this->tags) )
            return array();
        
        $tags = explode(",", $this->tags);
        return $tags;
    }
    
    /**
     * Get all entries with user relationship
     * Improved query performance of the relationship. 
     * 
     * @param int $page entries by page number
     * @return array Array of entries
     */
    public static function get_with_author($page){
        return Entry::with("user")->orderBy('time_created','desc')->paginate($page);
    }
    

    /**
     * Create User Object , update dates for object
     * 
     * @param mixed $data User attributes filled
     * @return mixed Object saved | boolean
     */
    public static function _save($data) {

        if ($data instanceof Entry) {
            $entry = $data;
        } elseif (is_array($data)) {

            //Check if fill data is no empty
            if (!count($data)) {
                return false;
            }
            //if attributes id is set, get entry
            if (isset($data["id"])) {
                $entry = Entry::find($data["id"]);
                if (!$entry instanceof Entry)
                    $entry = new Entry;
            }else {
                $entry = new Entry;

                //Save entry object
                $entry->title = $data["title"];
                $entry->content = $data["content"];
                $entry->user_id = $data["user_id"];
                $entry->tags = $data["tags"];
            }
        }else{
            //Paramater no accepted
            return false;
        }

        $entry->time_created = (isset($entry->id) && $entry->id) ? $entry->time_created : \time();
        $entry->time_updated = \time();


        //Save User in database, and return Object
        if ($entry->save()) {
            return $entry;
        }

        return false;
    }

}
