<?php

namespace App\Models;

use Core\Database\Model as Model;

class UsersModel extends Model
{
    public $UserId;
    public $Username;
    public $Firstname;
    public $Lastname;
    public $Password;
    public $Email;
    public $SubscriptionDate;
    public $LastUpdate;
    public $LastLogin;
    public $GroupId;
    public $Status;



    protected static $tableName = 'app_users';

    protected static $tableSchema = array(
      'UserId'            => self::DATA_TYPE_INT,
      'Username'          => self::DATA_TYPE_STR,
      'Firstname'         => self::DATA_TYPE_STR,
      'Lastname'          => self::DATA_TYPE_STR,
      'Password'          => self::DATA_TYPE_STR,
      'Email'             => self::DATA_TYPE_STR,
      'SubscriptionDate'  => self::DATA_TYPE_STR,
      'LastUpdate'        => self::DATA_TYPE_STR,
      'LastLogin'         => self::DATA_TYPE_STR,
      'GroupId'           => self::DATA_TYPE_INT,
      'Status'            => self::DATA_TYPE_INT,
      );

    protected static $primaryKey = 'UserId';

    public static function authenticate($username, $password, $session)
    {
        $password = crypt($password, APP_SALT) ;
        $sql = 'SELECT * FROM ' . self::$tableName . ' WHERE Username = "' . $username . '" AND Password = "' .  $password . '"';
        $foundUser = self::getOne($sql);
        if (false !== $foundUser) {
            $session_name = SESSION_WEB;
            $session->$session_name =  $foundUser;
            return true;
        }
        return false;
    }
}
