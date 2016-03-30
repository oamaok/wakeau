<?php

require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Renderer.php';

require_once __DIR__ . '/../models/Resource.php';
require_once __DIR__ . '/../models/Session.php';
require_once __DIR__ . '/../models/User.php';



Router::get('/', function () {
	Renderer::render('head');
	Renderer::render('login_form');
	Renderer::render('foot');
});

Router::post('/login', function () {

});

Router::get('/resource/(\w+)', function ($resource_token) {

});
