<form class="form-search" method="POST" action="<?=ROOT_URL?>">
  <input type="text" class="input-large" name="search" value="<?=$search?>"/>
  <button type="submit" class="btn btn-primary ">Search keys</button>
</form>

<form method="POST" action="<?=ROOT_URL?>delete">

<table class="table table-condensed table-bordered">
  <tr>
    <th>Key</th>
    <th>Type</th>
    <th>Hit</th>
    <th><i class="icon-fire"></i></th>
  </tr>
  <? foreach($keys as $key => $key_data): ?>
  <tr>
    <td><a href="key/<?=$key?>"><?=$key?></a></td>
    <td><?=$key_data['type_str']?></td>
    <td>
      <?=($key_data['hits'] ? $key_data['hits'] : '-' )?>
    </td>
    <td>
      <input type="checkbox" name="keys[]" value="<?=$key?>" checked="checked" />
    </td>
  </tr>
  <? endforeach; ?>
</table>

<button class="btn btn-danger pull-right" type="submit">Delete selected keys</button>

</form>
