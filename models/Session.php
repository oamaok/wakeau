<?php

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Model.php';

class Session implements Model
{
  public $access_token, $user, $created_at, $last_active, $ttl;

  private $_user = null;

  public static function from_array ($arr)
  {
    $session = new Session;
    $session->access_token = $arr['access_token'];
    $session->user = $arr['user'];
    $session->ttl = $arr['ttl'];
    $session->created_at = $arr['created_at'];
    $session->last_active = $arr['last_active'];

    return $session;
  }
  
  public static function find_by_id ($id) {}

  public static function create_token ()
  {
    return bin2hex(openssl_random_pseudo_bytes(32));
  }

  public static function create_for_user ($user_id, $ttl = null)
  {
    if(!$ttl)
      $ttl = Config::get('session')['ttl'];

    $session = new Session;
    $session->access_token = self::create_token();
    $session->user = $user_id;
    $session->ttl = $ttl;
    $session->created_at = Database::now();
    $session->last_active = Database::now();

    $result = Database::instance()->query('INSERT INTO sessions (access_token, "user", ttl, created_at, last_active) VALUES (?, ?, ?, NOW(), NOW()) RETURNING *', $session->access_token, $session->user, $session->ttl);
    
    $session->id = $result[0]['id'];
    return $session;
  }

  public static function find_by_token ($token)
  {
    $result = Database::instance()->query('SELECT * FROM sessions WHERE access_token = ? AND now () - last_active < ttl * interval \'1 second\'', $token);
    if(!count($result))
      return null;

    return Session::from_array($result[0]);
  }

  public static function get_current ()
  {
    if(!isset($_COOKIE[Config::get('session')['cookie']]))
      return null;

    $token = $_COOKIE[Config::get('session')['cookie']];
    return Session::find_by_token($token);
  }

  public function get_user ()
  {
    if(!$this->_user)
      $this->_user = User::find_by_id($session->user);
    return $this->_user;
  }
}