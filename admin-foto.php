<?php

use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Foto;

$app->get("/admin/fotos", function(){

	User::verifyLogin();

	$fotos = Foto::listAll();

	$page = new PageAdmin();

	$page->setTpl("fotos", [
     "fotos"=>$fotos
	]);
});

$app->get("/admin/fotos/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("fotos-create");
});

$app->post("/admin/fotos/create", function(){

	User::verifyLogin();

	$foto = new Foto();

	$foto->setData($_POST);

	$foto->save();

	if($_FILES["file"]["name"] !== "") $foto->setPhoto($_FILES['file']);

	header("Location: /admin/fotos");
	exit;
});

$app->get("/admin/fotos/:idfoto", function($idfoto){

	User::verifyLogin();

	$foto = new Foto();

	$foto->get((int)$idfoto);

	$page = new PageAdmin();

	$page->setTpl("fotos-update", [
     'foto'=>$foto->getValues()
	]);
});

$app->post("/admin/fotos/:idfoto", function($idfoto){

	User::verifyLogin();

	$foto = new Foto();

	$foto->get((int)$idfoto);

	$foto->setData($_POST);

	$foto->save();

	if($_FILES["file"]["name"] !== "") $foto->setPhoto($_FILES["file"]);

	header('Location: /admin/fotos');
	exit;
});

$app->get("/admin/fotos/:idfoto/delete", function($idfoto){

	User::verifyLogin();

	$foto = new Foto();

	$foto->get((int)$idfoto);

    $foto->delete();

    header("Location: /admin/fotos");
    exit;
});



?>