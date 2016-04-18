<?php

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Session.php';

class User implements Model
{
  public $id, $username;
  private $password;

  public static function from_array ($arr) 
  {
    $user = new User;
    $user->id = $arr['id'];
    $user->username = $arr['username'];
    $user->password = $arr['password'];

    return $user;
  }

  public static function find_by_id ($id)
  {

  }

  public static function create ($username, $password)
  {
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $result = Database::instance()->query('INSERT INTO users (username, password) VALUES (?, ?) RETURNING *', $username, $hash);
    if(!count($result))
      return null;
    return User::from_array($result[0]);
  }

  public static function login ($username, $password)
  {
    $ret = null;
    $t = microtime(true);

    do {
      $result = Database::instance()->query('SELECT * FROM users WHERE username = ?', $username);
      if(!count($result))
        break;

      $user_arr = $result[0];
      if(!password_verify($password, $user_arr['password']))
        break;

      $ret = User::from_array($user_arr);
    } while(0);

    usleep($t - microtime(true) + 1000000);
    return $ret;
  }

  public static function logout ()
  {

  }
}