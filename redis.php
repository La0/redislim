<?php

class RedisServer {
  private $redis = null;

  private static $types = array(
    Redis::REDIS_STRING => 'string',
    Redis::REDIS_SET => 'set',
    Redis::REDIS_LIST => 'list',
    Redis::REDIS_ZSET => 'zset',
    Redis::REDIS_HASH => 'hash',
    Redis::REDIS_NOT_FOUND => 'other',
  );

  //Connect to redis server
  public function __construct($host='127.0.0.1', $port=6379, $password=false){
    $this->redis = new Redis();
    if(!$this->redis->connect($host, $port))
      throw new Exception("Invalid connection on $host:$port");
    if($password && !$this->redis->auth($password))
      throw new Exception("Invalid password.");
  }

  public function search($filter = '*', $page = 1, $nb_page = 20){
    $keys_raw = $this->redis->keys($filter);
    sort($keys_raw);

    $keys = array();
    foreach($keys_raw as $k){

      //If valid hit, just add it to the key's data
      // that is already there in $keys because of sort
      if(substr($k, -5) == '_hits'){
        $src_key = substr($k, 0, -5);
        if(in_array($src_key, $keys_raw)){
          $keys[$src_key]['hits'] = (int)$this->redis->get($k);
          continue;
        }
      }

      $keys[$k] = $this->get_type($k);
    }

    return $keys;
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
    }
    return compact('key', 'type', 'type_str', 'data');
  }

  public function delete($keys){
    return $this->redis->delete($keys);
  }

  private function get_type($key){
    $type = $this->redis->type($key);
    return array(
      'type' => $type,
      'type_str' => self::$types[$type],
    );
  }

}

