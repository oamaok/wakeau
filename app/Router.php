<?php

class Route
{
  public $method, $regex, $cb;
}

class Router
{

  private static $routes = [];
  public static function redirect ($location)
  {
    header('Location: ' . $location);
  }

  public static function get ($regex, $cb)
  {
    $route = new Route;
    $route->method = 'GET';
    $route->regex = $regex;
    $route->cb = $cb;

    array_push(self::$routes, $route);
  }

  public static function post ($regex, $cb) 
  {
    $route = new Route;
    $route->method = 'POST';
    $route->regex = $regex;
    $route->cb = $cb;

    array_push(self::$routes, $route);
  }

  public static function run () 
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri =  explode('?', $_SERVER['REQUEST_URI'])[0];
    echo $uri;
    foreach(self::$routes as $route) {
      if ($route->method != $method)
        continue;
      
      $regex = '/^' . str_replace('/', '\\/', $route->regex) . '$/';
      if(preg_match_all($regex, $uri, $matches)) {
        $args = array_map(function ($m) { return $m[0]; }, array_slice($matches, 1));
        call_user_func_array($route->cb, $args);
      }
    }
  }
}