<?php

class Config 
{
  private static $cfg = null;

  public static function get ($type) {
    if(!self::$cfg)
      self::$cfg = parse_ini_file(__DIR__ . '/../config.ini', true);

    return self::$cfg[$type];
  }
}