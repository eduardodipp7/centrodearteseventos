<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Centro de artes e eventos em passo fundo é um local pra eventos de formaturas, casamentos e aniversários ">
    <meta name="keywords" content="centro de artes e eventos, Centro de Artes e Eventos, CENTRO DE ARTES E EVENTOS, centro de artes e ventos passo fundo, Centro de eventos Passo Fundo">
    <meta name="robots" content="">
    <meta name="revisit-after" content="1 day">
    <meta name="language" content="Portuguese">
    <meta name="generator" content="N/A">
   <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
    <title>Centro de Artes e Eventos</title>
    <link rel="stylesheet" href="/res/site/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <!-- Inicio do preloader-->
    <div id="preloader">
        <div class="inner">
            <div class="bolas">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- fim do preloader-->
    <header class="cabecalho">
        <div class="container">
            <h1 class="logo anime">Centro de Artes e Eventos Passo Fundo</h1>
            <nav class="menu-principal menu-principal--fechado">
                <button class="menu-principal__btn">Abrir/fechar menu</button>
                <ul class="menu-principal__lista">
                <li><a class="menu-principal__item menu-principal__item--atual" href="/">Home</a></li>
                    <?php require $this->checkTemplate("categories-menu");?>
                    
                    
                </ul>
            </nav>
        </div> <!-- fim container -->
    </header> 