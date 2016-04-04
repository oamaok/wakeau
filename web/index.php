<?php

require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Renderer.php';

require_once __DIR__ . '/../models/Resource.php';
require_once __DIR__ . '/../models/Session.php';
require_once __DIR__ . '/../models/User.php';

Router::get('/', function () {

  // Generate plasma palette
  $palette = [];

  $points = [
    [12,8,10],
    [24,11,27],
    [57,25,31],
    [72,30,39],
    [87,35,47],
    [120,60,57],
    [160,85,59]
  ];

  function lerp($a, $b, $x)
  {
    return (1 - $x) * $a + $x * $b;
  }

  for ($i = 0; $i < 255; $i++) {
    $point_count = count($points) - 1;
    $current_point = floor($i / 255 * $point_count);

    $point_a = $points[$current_point];
    $point_b = $points[$current_point + 1];

    $modulo = 255 / $point_count;
    $interp = fmod($i, $modulo) / $modulo;

    $palette[$i] = [];
    $palette[$i][0] = floor(lerp($point_a[0], $point_b[0], $interp));
    $palette[$i][1] = floor(lerp($point_a[1], $point_b[1], $interp));
    $palette[$i][2] = floor(lerp($point_a[2], $point_b[2], $interp));
  }


  Renderer::render('head');
  Renderer::render('login_form', array("palette" => json_encode($palette)));
  Renderer::render('foot');
});

Router::post('/login', function () {
  $user = User::login($_POST['username'], $_POST['password']);
  if(!$user) {
    Router::redirect('/#login-failed');
    exit(0);
  }
  var_dump(Session::create_for_user($user));
});

Router::get('/resource/(\w+)', function ($resource_token) {
  var_dump($resource_token);
});

Router::run();