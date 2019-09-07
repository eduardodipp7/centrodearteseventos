<?php

use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Fazemos;

$app->get("/admin/fazemos", function(){

	User::verifyLogin();

	$fazemos = Fazemos::listAll();

	$page = new PageAdmin();

	$page->setTpl("fazemos", [
     "fazemos"=>$fazemos
	]);
});

$app->get("/admin/fazemos/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("fazemos-create");
});

$app->post("/admin/fazemos/create", function(){

	User::verifyLogin();

	$fazemos = new Fazemos();

	$fazemos->setData($_POST);

	$fazemos->save();

	if($_FILES["file"]["name"] !== "") $fazemos->setPhoto($_FILES['file']);

	header("Location: /admin/fazemos");
	exit;
});

$app->get("/admin/fazemos/:idfazemos", function($idfazemos){

	User::verifyLogin();

	$fazemos = new Fazemos();

	$fazemos->get((int)$idfazemos);

	$page = new PageAdmin();

	$page->setTpl("fazemos-update", [
     'fazemos'=>$fazemos->getValues()
	]);
});

$app->post("/admin/fazemos/:idfazemos", function($idfazemos){

	User::verifyLogin();

	$fazemos = new Fazemos();

	$fazemos->get((int)$idfazemos);

	$fazemos->setData($_POST);

	$fazemos->save();

	if($_FILES["file"]["name"] !== "") $fazemos->setPhoto($_FILES["file"]);

	header('Location: /admin/fazemos');
	exit;
});

$app->get("/admin/fazemos/:idfazemos/delete", function($idfazemos){

	User::verifyLogin();

	$fazemos = new Fazemos();

	$fazemos->get((int)$idfazemos);

    $fazemos->delete();

    header("Location: /admin/fazemos");
    exit;
});



?>