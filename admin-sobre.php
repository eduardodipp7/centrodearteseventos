<?php

use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Sobre;

$app->get("/admin/sobre", function(){

	User::verifyLogin();

	$sobre = Sobre::listAll();

	$page = new PageAdmin();

	$page->setTpl("sobre", [
     "sobre"=>$sobre
	]);
});

$app->get("/admin/sobre/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("sobre-create");
});

$app->post("/admin/sobre/create", function(){

	User::verifyLogin();

	$sobre = new Sobre();

	$sobre->setData($_POST);

	$sobre->save();

	if($_FILES["file"]["name"] !== "") $sobre->setPhoto($_FILES['file']);

	header("Location: /admin/sobre");
	exit;
});

$app->get("/admin/sobre/:idsobre", function($idsobre){

	User::verifyLogin();

	$sobre = new Sobre();

	$sobre->get((int)$idsobre);

	$page = new PageAdmin();

	$page->setTpl("sobre-update", [
     'sobre'=>$sobre->getValues()
	]);
});

$app->post("/admin/sobre/:idsobre", function($idsobre){

	User::verifyLogin();

	$sobre = new Sobre();

	$sobre->get((int)$idsobre);

	$sobre->setData($_POST);

	$sobre->save();

	if($_FILES["file"]["name"] !== "") $sobre->setPhoto($_FILES["file"]);

	header('Location: /admin/sobre');
	exit;
});

$app->get("/admin/sobre/:idsobre/delete", function($idsobre){

	User::verifyLogin();

	$sobre = new Sobre();

	$sobre->get((int)$idsobre);

    $sobre->delete();

    header("Location: /admin/sobre");
    exit;
});



?>