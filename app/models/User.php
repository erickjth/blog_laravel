<?php
/**
 * Description of Entry
 *
 * @author erick
 */

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * The attributes from database table.
     *
     * @var array
     */
    protected $fillable = array('username', 'email', 'password', 'twitter_account', 'time_created');

    //Disable timestamps 
    public $timestamps = false;
    
    //Array of rules form by this model
    public static $rules_validator = array(
        'username' => 'required|alpha|min:2',
        'email' => 'required|email|unique:users',
        'twitter_account'=>'required|regex:/^@(\w){1,15}$/',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:6,12'
    );
    
    /**
     * Define relationship for entries
     **/
    public function entries()
    {
        return $this->hasMany('Entry');
    }
    
    /**
     * Define relationship for Twitter Entries
     **/
    public function tweets()
    {
        return $this->hasMany('Tweet');
    }
    
    /**
     * Get all users with relationship
     * Improved query performance of the relationship. 
     * 
     * @return array Array of users
     */
    
    public static function get_with_entries(){
        return User::with('entries')->get();
    }
    
    public function get_last_tweet() {
       return $this->from("twitter_entries")->where("user_id","=",$this->id)->orderBy('tw_id','desc')->first();
    }
    
    public function get_tweets($page, $hidden = null) {
        $query = $this->from("twitter_entries")
                ->where("user_id", "=", $this->id);
        if ($hidden) {
            $query->where("is_hidden", "=", 0);
        }
        $query->orderBy('tw_id', 'desc');

        return $query->paginate($page);
    }
    
    /**
     * Create User Object 
     * 
     * @param array $data User attributes filled
     * @return mixed Object saved | boolean
     */
    public static function _save($data=array()){
        //Check if fill data is no empty
        if( !count($data) ){ return false; }
              
        //Create new User OBject
        $user = new User;
        $user->username = $data["username"];
        $user->email = $data["email"];
        $user->password = Hash::make($data["password"]);
        $user->twitter_account = $data["twitter_account"];
        $user->time_created = \time();
        
        //Save User in database, and return Object
        if( $user->save() ){
            return $user;
        }
        
        return false;
    }
}
