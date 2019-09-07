<?php 
use \Projeto\Page;
use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Category;

$app->get("/admin/menus", function(){

    User::verifyLogin();

	$categories = Category::listAll();

	$page  = new PageAdmin();

	$page->setTpl("menus", [
     "categories"=>$categories
	]);
});

$app->get("/admin/menus/create", function(){

   User::verifyLogin();
	$page  = new PageAdmin();

	$page->setTpl("menus-create");


});

$app->post("/admin/menus/create", function(){
	   User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/menus");
	exit;


});

$app->get("/admin/menus/:idcategory/delete", function($idcategory){
	   User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header("Location: /admin/menus");
	exit;
});

$app->get("/admin/menus/:idcategory", function($idcategory){
	   User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page  = new PageAdmin();

	$page->setTpl("menus-update", [
		"category"=>$category->getValues()

	]);

});

$app->post("/admin/menus/:idcategory", function($idcategory){
	   User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/menus");
	exit;
});




?>