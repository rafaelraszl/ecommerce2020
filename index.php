<?php 

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
    
	$page = new PageAdmin();
    
    $page->setTpl("index");

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

$app->run();

 ?>
