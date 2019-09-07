<?php

use \Projeto\Page;
use \Projeto\Model\Foto;
use \Projeto\Model\Fazemos;
use \Projeto\Model\Post;
use \Projeto\Model\Portfolio;
use \Projeto\Model\Sobre;
use \Projeto\Envia;

$app->get('/', function() {
    
    $fazemos = Fazemos::listAll();
    $post = Post::listAll();
	$page = new Page();

	$page->setTpl("index", [
     'fazemos'=>Fazemos::checklist($fazemos),
     'post'=>Post::checklist($post)
	]);

});

$app->get("/sobre", function(){

	$sobre = Sobre::listAll();

	$page = new Page();

	$page->setTpl("sobre", [
     'sobre'=>Sobre::checklist($sobre)
	]);


});

$app->get("/portfolio", function(){

	$fotos = Foto::listAll();
	$port = Portfolio::listAll();

	$page = new Page();

	$page->setTpl("portfolio", [
    'fotos'=>Foto::checklist($fotos),
    'port'=>$port
	]);


});

$app->get("/contato", function(){

	$page = new Page();

	$page->setTpl("contato");

});

$app->post("/contato", function(){
      
      $envia = new Envia($_POST["nome"], $_POST["email"], $_POST["mensagem"]);

	/*$envia = new Mailer($email, $nome, "Centro de Artes e Eventos Teste", "resposta", 
	array(
    "name"=>$nome
	));*/

	header("Location: /contato/enviado");
	exit;
});

$app->get("/contato/enviado", function(){

	$page = new Page([
     "header"=>false,
     "footer"=>false
	]);

	$page->setTpl("enviado");

	header("refresh: 5;/contato");
});

?>