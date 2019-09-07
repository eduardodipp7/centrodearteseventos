<?php

use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Post;

$app->get("/admin/post", function(){

	User::verifyLogin();

	$post = Post::listAll();

	$page = new PageAdmin();

	$page->setTpl("post", [
     "post"=>$post
	]);
});

$app->get("/admin/post/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("post-create");
});

$app->post("/admin/post/create", function(){

	User::verifyLogin();

	$post = new Post();

	$post->setData($_POST);

	$post->save();

	if($_FILES["file"]["name"] !== "") $post->setPhoto($_FILES['file']);

	header("Location: /admin/post");
	exit;
});

$app->get("/admin/post/:idpost", function($idpost){

	User::verifyLogin();

	$post = new Post();

	$post->get((int)$idpost);

	$page = new PageAdmin();

	$page->setTpl("post-update", [
     'post'=>$post->getValues()
	]);
});

$app->post("/admin/post/:idpost", function($idpost){

	User::verifyLogin();

	$post = new Post();

	$post->get((int)$idpost);

	$post->setData($_POST);

	$post->save();

	if($_FILES["file"]["name"] !== "") $post->setPhoto($_FILES["file"]);

	header('Location: /admin/post');
	exit;
});

$app->get("/admin/post/:idpost/delete", function($idpost){

	User::verifyLogin();

	$post = new Post();

	$post->get((int)$idpost);

    $post->delete();

    header("Location: /admin/post");
    exit;
});



?>