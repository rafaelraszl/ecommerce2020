<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Mekhet\Page;
use \Mekhet\PageAdmin;
use \Mekhet\Model\User;


$app = new \Slim\Slim();

$app->config('debug', true);

// ROTA INDEX SITE
$app->get('/', function() {
    
	$page = new Page();
    
    $page->setTpl("index");

});

// ROTA INDEX ADMIN
$app->get('/admin', function() {

	User::verifyLogin(); //método que verifica se está logado

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("index", array(
		"users"=>$users
	));

});

// ROTA TELA LOGIN ADM
$app->get('/admin/login', function() {
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
    
    $page->setTpl("login");

});

// ROTA LOGIN ADM
$app->post('/admin/login', function() {

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

// ROTA LOGOUT
$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;
});

// ROTA TELA QUE LISTA TODOS OS USUÁRIOS ADMIN
$app->get("/admin/users", function() {

	User::verifyLogin(); //método que verifica se está logado

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));
});

//ROTA TELA PARA CADASTRAR USUÁRIOS DO ADMIN
$app->get("/admin/users/create", function() {

	User::verifyLogin(); //método que verifica se está logado

	$page = new PageAdmin();

	$page->setTpl("users-create");
});

//ROTA PARA DELETAR USUÁRIO
$app->get("/admin/users/:iduser/delete", function($iduser) {

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;	
});

//ROTA TELA PARA EDITAR USUÁRIOS DO ADMIN
$app->get('/admin/users/:iduser', function($iduser){
 
   User::verifyLogin();
 
   $user = new User();
 
   $user->get((int)$iduser);
 
   $page = new PageAdmin();
 
   $page ->setTpl("users-update", array(
        "user"=>$user->getValues()
    ));
 
});

//ROTA PARA SALVAR CADASTRO DE USUÁRIO
$app->post("/admin/users/create", function () {

 	User::verifyLogin();

	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

 	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
 	exit;

});

//ROTA PARA SALVAR ALTERAÇÃO DE USUÁRIO
$app->post("/admin/users/:iduser", function($iduser) {

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;	
});

$app->get("/admin/forgot", function() {

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot");
});

$app->run();

 ?>
