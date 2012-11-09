<p class="pull-right">
  <a href="<?=ROOT_URL?>" class="btn btn-success">Back to home</a>
</p>

<h1>Deleted <?=count($keys)?> keys</h1>
<ul>
<? foreach($keys as $k): ?>
  <li><?=$k?></li>
<? endforeach; ?>
</ul>
