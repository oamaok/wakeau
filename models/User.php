<?php

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Session.php';

class User
{
  public $id, $username, $password;

  public static function from_array ($arr) 
  {
    $user = new User;
    $user->id = $arr['id'];
    $user->username = $arr['username'];
    $user->password = $arr['password'];
  }

  public static function find_by_id ($id)
  {

  }

  public static function create ($username, $password)
  {
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
  }

  public static function login ($username, $password)
  {
    $result = Database::instance()->query('SELECT * FROM users WHERE username = ?', $username);

    if(!count($result))
      return null;

    $user = $result[0];

    if(!password_verify($password, $user['password']))
      return null;

    return User::fromArray($user);
  }

  public static function logout ()
  {

  }
}