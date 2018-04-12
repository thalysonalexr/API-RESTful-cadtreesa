<?php
/**
 * This file contains all routes of this API. For more information see the documentation.
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @see Documentation
 * @link https://thalysonrodrigues.github.io/API-RESTful-cadtreesa/
 * @link https://github.com/thalysonrodrigues/API-RESTful-Cadtreesa/blob/master/docs/api.apib
 */

use Respect\Rest\Router;
use Cadtreesa\classes\Auth;


$route = new Router;


// Routes for users

$route->post('/v1/users/login', \Cadtreesa\Controllers\User\Post\PostLogin::class);

$route->post('/v1/users/logout', \Cadtreesa\Controllers\User\Post\PostLogout::class);

$route->post('/v1/users', \Cadtreesa\Controllers\User\Post\Post::class);

$route->post('/v1/users/forgot_password', \Cadtreesa\Controllers\User\Post\PostForgotPassword::class);

$route->post('/v1/users/change_password', \Cadtreesa\Controllers\User\Post\PostChangePassword::class);

$route->get('/v1/users/*', \Cadtreesa\Controllers\User\Get\Get::class)->by(function() use ($route) {
	$id = isset($route->request->params[0]) ? $route->request->params[0]: null;
	Auth::auth(array(
		 'STD' => true, 'TCR' => false, 'CDR' => false
	), $id); 
});

$route->get('/v1/users', \Cadtreesa\Controllers\User\Get\GetAll::class)->by(function() {
	Auth::auth(array(
		'CDR' => false
	));
});

$route->get('/v1/users/*/trees/*', \Cadtreesa\Controllers\Tree\Get\GetOneByUser::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

$route->get('/v1/users/*/trees', \Cadtreesa\Controllers\Tree\Get\GetAllByUser::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

$route->put('/v1/users/*', \Cadtreesa\Controllers\User\Put\Put::class)->by(function() use ($route) {
	$id = isset($route->request->params[0]) ? $route->request->params[0]: null;
	Auth::auth(array(
		'STD' => true, 'TCR' => true, 'CDR' => true
	), $id );
});

$route->delete('/v1/users/*', \Cadtreesa\Controllers\User\Delete\Delete::class)->by(function() use ($route) {
	$id = isset($route->request->params[0]) ? $route->request->params[0]: null;
	Auth::auth(array(
		'STD' => true, 'TCR' => true, 'CDR' -> true
	), $id );
});

// Routes for trees

$route->post('/v1/trees', \Cadtreesa\Controllers\Tree\Post\Post::class)->by(function() {
	Auth::auth(array(
		'STD' => false, 'TCR' => false, 'CDR' => false
	));
});

$route->get('/v1/trees', \Cadtreesa\Controllers\Tree\Get\GetAll::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

$route->get('/v1/trees/*', \Cadtreesa\Controllers\Tree\Get\Get::class)->by(function() {
	if (isset($_GET['extends']) && $_GET['extends'] === 'users') {
		Auth::auth(array(
			'TCR' => false, 'CDR' => false
		));
	}
});

$route->get('/v1/trees/*/users', \Cadtreesa\Controllers\User\Get\GetByTree::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

$route->put('/v1/trees/*', \Cadtreesa\Controllers\Tree\Put\Put::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

$route->delete('/v1/trees/*', \Cadtreesa\Controllers\Tree\Delete\Delete::class)->by(function() {
	Auth::auth(array(
		'TCR' => false, 'CDR' => false
	));
});

// Other routes

$route->post('/v1/mail', \Cadtreesa\Controllers\Mail\Post\Post::class);

$route->any('/*', function () {
	require "index.html";
});

$route->exceptionRoute('IvalidArgumentException', function (InvalidArgumentException $e) {
	return 'Ops! This route is not enable. Please, read documentation in https://thalysonrodrigues.github.io/API-RESTful-cadtreesa/';
});

$route->errorRoute(function (array $err) {
    return 'Sorry, this errors happened.' . var_dump($err);
});