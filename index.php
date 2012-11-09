<?php
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASSWORD', false);

require 'vendor/autoload.php';

//Classes
require 'redis.php';

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

//Load redis server
try{
  $redis = new RedisServer(REDIS_HOST, REDIS_PORT, REDIS_PASSWORD);
}catch(Exception $e){
  $app->render('error.php', array('message' => $e->getMessage()));
}

/*
$app->get('/search/:search', 'search');
$app->get('/key/:key', 'key');
*/

//Index
$app->get('/', function() use ($app, $redis) {
  if(!$redis) return;
  $keys = $redis->search();
  $app->render('index.php', array('keys' => $keys));
});

//Run !
$app->run();
