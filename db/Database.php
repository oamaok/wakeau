<?php

require_once __DIR__ . '/../app/Config.php';

class Database
{
  private static $_instance = null;
  private $pdo = null;

  private function __construct ()
  {
    $db_config = Config::get('database');
    $dsn = sprintf('%s:dbname=%s;host=%s', $db_config['driver'], $db_config['name'], $db_config['host']);

    if(isset($db_config['port']))
      $dsn .= ';port=' . $db_config['port'];

    $this->pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
  }

  public static function instance () 
  {
    if(self::$_instance == null)
      self::$_instance = new Database();

    return self::$_instance;
  }

  public function query (...$args)
  {
    $statement = $this->pdo->prepare($args[0]);
    $statement->execute(array_slice($args, 1));
    return $statement->fetchAll();
  }

  public static function now ()
  {
    return date("c");
  }
}