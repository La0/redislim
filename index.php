<?php
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_PASSWORD', false);
define('ROOT_URL', '/');

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

//Index
$app->get('/', function() use ($app, $redis) {
  if(!$redis) return;
  $app->render('index.php', array('keys' => $redis->search()));
});

//Search
$app->post('/', function() use ($app, $redis) {
  if(!$redis) return;
  $search = trim($_POST['search']);
  if(!$search)
    $search = '*'; // all keys by default
  $app->render('index.php', array(
    'keys' => $redis->search($search),
    'search' => $search,
  ));
});

//Load key
$app->get('/key/:key', function($key) use ($app, $redis){
  $app->render('key.php', array('key' => $redis->get($key)));
});

//Infos
$app->get('/infos', function() use ($app, $redis) {
  $app->render('infos.php', array('infos' => $redis->infos()));
});

//Run !
$app->run();
