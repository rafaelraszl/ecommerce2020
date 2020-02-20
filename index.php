<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Mekhet\Page;
use \Mekhet\PageAdmin;


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

$app->run();

 ?>
