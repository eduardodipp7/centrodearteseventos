<?php 

session_start();
require_once("vendor/autoload.php");

$app = new \Slim\Slim();

require_once("functions.php");
require_once("site.php");
require_once("rota-admin.php");
require_once("admin-user.php");
require_once("admin-menus.php");
require_once("admin-forgot.php");
require_once("admin-foto.php");
require_once("admin-fazemos.php");
require_once("admin-post.php");
require_once("admin-portfolio.php");
require_once("admin-sobre.php");



$app->config('debug', true);


$app->run();

 ?>