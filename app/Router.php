<?php

class Route
{
	public $method, $regex, $cb;
}

class Router
{

	private static $routes = [];

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
		$uri = $_SERVER['REQUEST_URI'];

		foreach(self::$routes as $route) {
			if ($route->method != $method)
				continue;
			
			$regex = '/^' . str_replace('/', '\\/', $route->regex) . '$/';
			if(preg_match_all($regex, $uri, $matches, PREG_SET_ORDER)) {
				$args = array_map(function ($m) { return $m[0]; }, array_slice($matches, 1)) 
				call_user_func($route->cb, $args);
			}
		}
	}
}