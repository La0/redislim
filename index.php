<?php
//Default configuration
$conf_defaults = array(
  'REDIS_HOST'    => '127.0.0.1',
  'REDIS_PORT'    => 6379,
  'REDIS_PASSWORD' => false,
  'ROOT_URL'      => '/',
  'ITEMS_PAGE'    => 50,
);

//Load configuration from config.json
$conf_file = 'config.json';
$conf = @json_decode(file_get_contents($conf_file), true);
if(!$conf)
  $conf = array();
$conf = array_merge($conf_defaults, $conf);
foreach($conf as $k => $v)
  define($k, $v);

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
  'view' => $layout,
));

//Error
$app->error(function(\Exception $e) use ($app) {
  $app->render('error.php', array('message' => $e->getMessage()));
});

//Load redis server
try{
  $redis = RedisServer::init(REDIS_HOST, REDIS_PORT, REDIS_PASSWORD);
}catch(Exception $e){
  $app->render('error.php', array('message' => $e->getMessage()));
}

//Index Paginated
$app->get('/', 'index');
$app->get('/page/:page', 'index');

function index($page = 1){
  $app = \Slim\Slim::getInstance();
  $redis = RedisServer::getInstance();
  if(!$redis) return;
  $app->render('index.php', $redis->search('*', $page, ITEMS_PAGE));
}

//Search
$app->post('/', 'search');
$app->get('/search/:search/page/:page', 'search');

function search($search = false, $page = 1) {
  $app = \Slim\Slim::getInstance();
  $redis = RedisServer::getInstance();
  if(!$redis) return;
  $search = $search ? $search : trim($_POST['search']);
  if(!$search)
    $search = '*'; // all keys by default
  $app->render('index.php', $redis->search($search, $page, ITEMS_PAGE));
}

//Load key
$app->get('/key/:key', function($key) use ($app, $redis){
  $app->render('key.php', array('key' => $redis->get($key)));
});

//Delete
$app->post('/delete', function() use ($app, $redis){

  $keys = $_POST['keys'];
  if(!$keys)
    throw new Exception("No keys to delete");

  $redis->delete($keys);
  $app->render('delete.php', array('keys' => $keys));
});

//Infos
$app->get('/infos', function() use ($app, $redis) {
  $app->render('infos.php', array('infos' => $redis->infos()));
});

//Run !
$app->run();
