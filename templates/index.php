<form class="form-search" method="POST" action="?">
  <input type="text" class="input-large" name="search" value="<?=$search?>"/>
  <button type="submit" class="btn btn-primary ">Search keys</button>
</form>

<table class="table table-condensed table-bordered">
  <tr>
    <th>Key</th>
    <th>Type</th>
    <th>Hit</th>
  </tr>
  <? foreach($keys as $key => $key_data): ?>
  <tr>
    <td><a href="key/<?=$key?>"><?=$key?></a></td>
    <td><?=$key_data['type_str']?></td>
    <td>
      <?=($key_data['hits'] ? $key_data['hits'] : '-' )?>
    </td>
  </tr>
  <? endforeach; ?>
</table>
