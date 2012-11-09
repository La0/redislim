<?php

require 'vendor/autoload.php';

//Layout View
require 'layoutview.php';
LayoutView::set_layout('layout.php');
$layout = new LayoutView();

// Setup app
$app = new \Slim\Slim(array(
  'mode' => 'development',
  'debug' => true,
  'view' => $layout,
));


/*
$app->get('/search/:search', 'search');
$app->get('/key/:key', 'key');
*/
//Index
$app->get('/', function() use ($app) {
  $app->render('index.php', array());
});

//Run !
$app->run();


