<?php 

use \Projeto\Model\User;


function formatDate($date){

	return date('d/m/Y', strtotime($date));
}

function checkLogin($inadmin = true){

	return User::checkLogin($inadmin);
}

function getUserName(){

	$user = User::getFromSession();

	return $user->getdesperson();
}

function getUserFoto(){

	$user = User::getFromSessionFoto();

	return $user->getdesphoto();
}


function FormataEditorPost($str){

	$textoOriginal = $str;
     
	$texto = trim($textoOriginal, '"');
	$texto = trim($textoOriginal, '<p>');

	str_replace("<p>", "<br>", $texto);

	$tags = array('</p>', '<pre>', '</pre>', '<div>', '</div>', '<blockquote>', '</blockquote>');
    $texto = str_replace($tags, "", $texto);

    return $texto;
}
function FormataEditor($str){

	$textoOriginal = $str;
     
	$texto = trim($textoOriginal, '"');

	str_replace("<p>", "<br>", $texto);

	$tags = array('</p>', '<pre>', '</pre>', '<div>', '</div>', '<blockquote>', '</blockquote>');
    $texto = str_replace($tags, "", $texto);

    return $texto;
}

?>