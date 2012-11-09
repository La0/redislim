<p class="pull-right">
  <a href="../" class="btn btn-success">Back to home</a>
</p>

<h1><?=$key['key']?></h1>
<p>
  <span class="badge"><?=$key['type_str']?></span>
</p>


<pre>
<?=htmlentities($key['data'])?>
</pre>
