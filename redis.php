<?php

class RedisServer {
  private $redis = null;

  private $hits_key = 'hits';
  private $hits = array();

  private static $types = array(
    Redis::REDIS_STRING => 'string',
    Redis::REDIS_SET => 'set',
    Redis::REDIS_LIST => 'list',
    Redis::REDIS_ZSET => 'zset',
    Redis::REDIS_HASH => 'hash',
    Redis::REDIS_NOT_FOUND => 'other',
  );

  public function __construct($host='127.0.0.1', $port=6379, $password=false){
    //Connect to redis server
    $this->redis = new Redis();
    if(!$this->redis->connect($host, $port))
      throw new Exception("Invalid connection on $host:$port");
    if($password && !$this->redis->auth($password))
      throw new Exception("Invalid password.");

    //Load hits
    $this->hits = $this->redis->hGetAll($this->hits_key);
  }

  //Instance
  private static $instance = null;
  public static function init($host='127.0.0.1', $port=6379, $password=false){
    if(self::$instance != null)
      throw new Exception("An instance of RedisServer is already created.");
    return self::$instance = new RedisServer($host, $port, $password);
  }

  public static function getInstance(){
    return self::$instance;
  }

  //Search keys and add theirs attributes (ttl, size, type)
  public function search($search = '*', $page = 0, $nb_page = 20){
    $keys_raw = $this->redis->keys($search);
    sort($keys_raw);

    //Build pagination
    $nb = count($keys_raw);
    $pagination = array('total' => $nb, 'page' => $page, 'last_page' => ceil($nb/$nb_page), 'nb_page' => $nb_page);
    if($page > 0)
      $keys_raw = array_slice($keys_raw, ($page-1) * $nb_page, $nb_page);

    $keys = array();
    foreach($keys_raw as $k){

      //Load type & hits
      $key_data = $this->get_type($k);
      if($this->hits[$k])
        $key_data['hits'] = $this->hits[$k];

      //Load size
      $key_data = array_merge($key_data, $this->get_size($k, $key_data['type']));

      //Load ttl
      $key_data = array_merge($key_data, $this->get_ttl($k));

      $keys[$k] = $key_data;
    }

    return compact('keys', 'pagination', 'search');
  }
  
  //Server status & infos
  public function infos(){
    return $this->redis->info();
  }

  public function get($key){
    $type = $this->redis->type($key);
    $data = null;
    $type_str = self::$types[$type];
    switch($type){
      case Redis::REDIS_STRING:
        $data = $this->redis->get($key);
        break;
      case Redis::REDIS_HASH:
        $data = $this->redis->hGetAll($key);
        break;
      case Redis::REDIS_SET:
        $data = $this->redis->sMembers($key);
        break;
    }
    return compact('key', 'type', 'type_str', 'data');
  }

  public function delete($keys){
    return $this->redis->delete($keys);
  }

  //Helper to get a key type & its according string
  private function get_type($key){
    $type = $this->redis->type($key);
    return array(
      'type' => $type,
      'type_str' => self::$types[$type],
    );
  }

  //Helper to get a key ttl
  private function get_ttl($key){
    $ttl = $this->redis->ttl($key);
    $ttl_str = $this->human_time($ttl);
    return compact('ttl', 'ttl_str');
  }

  //Helper to get a key size
  private function get_size($key, $type){
    $size = $size_str = 0;
    switch($type){
      case Redis::REDIS_STRING:
        $size = $this->redis->strlen($key);
        $size_str = $this->human_size($size);
        break;
      case Redis::REDIS_HASH:
        $size = $size_str = $this->redis->hLen($key);
        break;
    }
    return compact('size', 'size_str');
  }

  //Get a human readable file size, thanks to yks.
  private function human_size($size){
    $size=sprintf("%f",$size);
    return ($size>>30) ? round($size/(1<<30),1).' Gb'
        : (($size>>20) ? round($size/(1<<20),1).' Mb'
           : (($size>>10) ? round($size/(1<<10),1).' Kb'
              :((int)$size)));
  }

  //Get a human readable time, from seconds
  private function human_time($time){
    $out = '';
    if($time > 86400){
      $days = (int)($time / (86400));
      $out .= "$days d ";
      $time = $time % (86400);
    }

    $hours = sprintf('%02s', (int)($time / 3600));
    $minutes = sprintf('%02s', (int)($time % 3600 / 60));
    $seconds = sprintf('%02s', (int)($time % 60));
    $out .= "$hours:$minutes:$seconds";

    return $out;
  }

}

