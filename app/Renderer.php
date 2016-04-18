<?php

// sigh
require_once __DIR__ . '/../vendor/mustache/mustache/src/Mustache/Autoloader.php';

class Renderer 
{
  private static $mustache = null;

  private static function init () 
  {
    Mustache_Autoloader::register();
    self::$mustache = new Mustache_Engine;
  }

  public static function json ($obj)
  {
    header('Content-type: text/json');
    echo json_encode($obj);
  }

	public static function render ($template, $data = null)
	{
    if(!self::$mustache)
      self::init();

		echo self::$mustache->render(file_get_contents(__DIR__ . '/../views/' . $template . '.html'), $data);
	}
}