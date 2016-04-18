<?php

require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Model.php';

class Request implements Model
{
  public $id, $timestamp, $referer, $user_agent, $ip;
  private static $_current = null;

  public static function from_array ($arr)
  {
    $req = new Request;
    $req->id = $arr['id'];
    $req->timestamp = $arr['timestamp'];
    $req->referer = $arr['referer'];
    $req->ip = $arr['ip'];
    $req->user_agent = $arr['user_agent'];

    return $req;
  }
  public static function find_by_id ($id) {}

  public static function get_current ()
  {
    if(!self::$_current) {
      $arr = Database::instance()->query('INSERT INTO requests
        (timestamp, referer, ip, user_agent)
        VALUES (NOW(), ?, ?, ?) RETURNING *',
        $_SERVER['HTTP_REFERER'],
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
      );
      self::$_current = Request::from_array($arr[0]);
    }

    return self::$_current;
  }

}