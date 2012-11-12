<html>
<head>
  <title>RediSlim</title>
  <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
  <style>
  body { padding-top: 60px; }
  </style>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="<?=ROOT_URL?>">RedisSlim</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="<?=ROOT_URL?>">Home</a></li>
          <li><a href="<?=ROOT_URL?>infos">Infos</a></li>
        </ul>
      </div>
      <div class="navbar-text pull-right">
        <?=REDIS_HOST?>:<?=REDIS_PORT?>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <?=$html ?>
</div>

</body>
</html>
