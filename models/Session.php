<?php

require_once __DIR__ . '/../db/Database.php';

class Session
{
  public $access_token, $user, $created_at, $last_active, $ttl;

  private $_user = null;

  public static function from_array ($arr)
  {
    $session = new Session;
    $session->access_token = self::create_token();
    $session->user = $user->id;
    $session->ttl = $ttl;
    $session->created_at = Database::now();
    $session->last_active = Database::now();
  }

  public static function create_token ()
  {
    return bin2hex(openssl_random_pseudo_bytes(16));
  }

  public static function create_for_user ($user, $ttl = 60 * 60 * 24 * 7)
  {
    $session = new Session;
    $session->access_token = self::create_token();
    $session->user = $user->id;
    $session->ttl = $ttl;
    $session->created_at = Database::now();
    $session->last_active = Database::now();

    var_dump(Database::instance()->query('INSERT INTO sessions (access_token, user, ttl, create_at, last_active) VALUES (?, ?, ?, NOW(), NOW()) RETURNING id', $session->access_token, $session->user, $session->ttl));

    return $session;
  }

  public static function get_by_token ($token)
  {
    $result = Database::instance()->query('SELECT * FROM sessions WHERE access_token = ? AND now () - last_active < ttl * interval \'1 second\'', $token);
    if(!count($result))
      return null;

    return Session::from_array($result[0]);
  }

  public static function get_current ()
  {
    
  }

  public function get_user ()
  {
    if(!$this->_user)
      $this->_user = User::find_by_id($session->user);
    return $this->_user;
  }
}