<?php

use \Projeto\Page;
use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Category;

//ROTA ADMIN
$app->get('/admin', function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");
});

$app->get('/admin/login/erro', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("erro");
});

$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;
});



?>