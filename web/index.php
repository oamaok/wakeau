<?php

require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Renderer.php';

require_once __DIR__ . '/../models/Resource.php';
require_once __DIR__ . '/../models/Session.php';
require_once __DIR__ . '/../models/User.php';

Router::get('/', function () {
  Renderer::render('index');
});

Router::post('/login', function () {
  if(!isset($_POST['username'], $_POST['password']))
    return Renderer::json(null);
  
  $user = User::login($_POST['username'], $_POST['password']);
  if(!$user)
    return Renderer::json(null);
  
  $session = Session::create_for_user($user->id);
  setcookie(Config::get('session')['cookie'], $session->access_token, time() + Config::get('session')['ttl']);
  
  $res = new stdClass;
  $res->session = $session;
  $res->user = $user;

  Renderer::json($res);
});

Router::get('/session', function () {
  $session = Session::get_current();
  if(!$session)
    return Renderer::json(null);
  
  $res = new stdClass;
  $res->session = $session;
  $res->user = $session->get_user();
  Renderer::json($res);
});


Router::get('/resource/(\w+)', function ($resource_token) {
  var_dump($resource_token);
});

Router::run();