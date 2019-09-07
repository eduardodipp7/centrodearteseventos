<?php

use \Projeto\Page;
use \Projeto\PageAdmin;
use \Projeto\Model\User;
use \Projeto\Model\Category;

$app->get('/admin/users', function(){

    //veirfica o login pra entrar na pagina
    User::verifyLogin();

    //metodo pra listar todos usuarios
    $users = User::listAll();

    $page = new PageAdmin();

    $page->setTpl("users", array(

        "users"=>$users

    ));
});

$app->get('/admin/users/create', function(){

    User::verifyLogin();

    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->get('/admin/users/:iduser/delete', function($iduser){

    User::verifyLogin();

    $user = new User();

    $user->get((int)$iduser);

    $user->delete();

    header("Location: /admin/users");
    exit;



});

$app->get('/admin/users/:iduser', function($iduser){

    User::verifyLogin();

    $user = new  User();
    $user->get((int)$iduser);

    $page = new PageAdmin();
    $page->setTpl("users-update", array(
     "user"=>$user->getValues()

    )); 

});

$app->post('/admin/users/create', function(){

    User::verifyLogin();

    $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

    $user->setData($_POST);

    $user->save();

    if($_FILES["file"]["name"] !== "") $user->setPhoto($_FILES['file']);

    header("Location: /admin/users");
    exit;


});

$app->post('/admin/users/:iduser', function($iduser){

    User::verifyLogin();

    $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

    $user->get((int)$iduser);

    $user->setData($_POST);

    $user->update();

    if($_FILES["file"]["name"] !== "") $user->setPhoto($_FILES['file']);




    header("Location: /admin/users");
    exit;

});

//ROTA QUE ALTERA A SENHA DO USUARIO

$app->get("/admin/users/:iduser/password", function($iduser){
    User::verifyLogin();
    $user = new User();
    $user->get((int)$iduser);
    $page = new PageAdmin();
    $page->setTpl("users-password", [
        'user'=>$user->getValues(),
        'msgError'=>User::getError(),
        'msgSuccess'=>User::getSuccess()
    ]);
});


$app->post("/admin/users/:iduser/password", function($iduser){
    User::verifyLogin();
    if (!isset($_POST['despassword']) || $_POST['despassword'] === '') {
        User::setError("Preencha a nova senha.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }
    if (!isset($_POST['despassword-confirm']) || $_POST['despassword-confirm'] === '') {
        User::setError("Preencha a confirmação nova senha.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }
    if ($_POST['despassword'] !== $_POST['despassword-confirm']) {
        User::setError("As senhas devem ser iguais.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }
    $user = new User();
    $user->get((int)$iduser);
    $user->setPassword(User::getPasswordHash($_POST['despassword']));
    User::setSuccess("Senha alterada com sucesso.");
        header("Location: /admin/users/$iduser/password");
        exit;
    
});


?>