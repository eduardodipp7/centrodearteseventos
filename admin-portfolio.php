<?php

use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Portfolio;

$app->get("/admin/port", function(){

	User::verifyLogin();

	$port = Portfolio::listAll();

	$page = new PageAdmin();

	$page->setTpl("port", [
     "port"=>$port
	]);
});

$app->get("/admin/port/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("port-create");
});

$app->post("/admin/port/create", function(){

	User::verifyLogin();

	$port = new Portfolio();

	$port->setData($_POST);

	$port->save();

	//if($_FILES["file"]["name"] !== "") $port->setPhoto($_FILES['file']);

	header("Location: /admin/port");
	exit;
});

$app->get("/admin/port/:idport", function($idport){

	User::verifyLogin();

	$port = new Portfolio();

	$port->get((int)$idport);

	$page = new PageAdmin();

	$page->setTpl("port-update", [
     'port'=>$port->getValues()
	]);
});

$app->post("/admin/port/:idport", function($idport){

	User::verifyLogin();

	$port = new Portfolio();

	$port->get((int)$idport);

	$port->setData($_POST);

	$port->save();

	//if($_FILES["file"]["name"] !== "") $port->setPhoto($_FILES["file"]);

	header('Location: /admin/port');
	exit;
});

$app->get("/admin/port/:idport/delete", function($idport){

	User::verifyLogin();

	$port = new Portfolio();

	$port->get((int)$idport);

    $port->delete();

    header("Location: /admin/port");
    exit;
});



?>