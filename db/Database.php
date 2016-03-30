<?php

class Database
{
  private static $__instance = null;
  private $pdo = null;

  private function __construct ()
  {
    $db_config = parse_ini_file(__DIR__ . '/../config.ini', true)['database'];
    $dsn = sprintf('%s:dbname=%s;host=%s', $db_config['driver'], $db_config['name'], $db_config['host']);

    if(isset($db_config['port']))
      $dsn .= ';port=' . $db_config['port'];

    $this->pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
  }

  public static function instance () 
  {
    if(self::$__instance == null)
      self::$__instance = new Database();

    return self::$__instance;
  }

  public function query (...$args)
  {
    $statement = $this->pdo->prepare($args[0]);
    $statement->execute(array_slice($args, 1));
    return $statement->fetchAll();
  }
}