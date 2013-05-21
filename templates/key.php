<p class="pull-right">
  <a href="<?=ROOT_URL?>" class="btn btn-success">Back to home</a>
</p>

<h1><?=$key['key']?></h1>
<p>
  <span class="badge"><?=$key['type_str']?></span>
</p>

<? if($key['type'] == Redis::REDIS_STRING): ?>
<pre>
<?=htmlentities($key['data'])?>
</pre>

<? elseif($key['type'] == Redis::REDIS_HASH): ?>

  <table class="table table-bordered">
  <tr>
    <th>Key</th>
    <th>Value</th>
  </tr>
  <? foreach($key['data'] as $k => $v): ?>
  <tr>
    <td><?=$k?></td>
    <td><?=$v?></td>
  </tr>
  <? endforeach; ?>
  </table>

<? elseif($key['type'] == Redis::REDIS_SET || $key['type'] == Redis::REDIS_ZSET || $key['type'] == Redis::REDIS_LIST): ?>

  <table class="table table-bordered">
  <tr>
    <th>Position</th>
    <th>Value</th>
  </tr>
  <? foreach($key['data'] as $pos => $v): ?>
  <tr>
    <td><?=$pos?></td>
    <td><?=$v?></td>
  </tr>
  <? endforeach; ?>
  </table>

<? else: ?>

<p class="alert alert-error">Unknown type !</p>
<? endif; ?>
