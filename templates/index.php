<table class="table table-condensed table-bordered">
  <tr>
    <th>Key</th>
    <th>Type</th>
    <th>Hit</th>
  </tr>
  <? foreach($keys as $key => $key_data): ?>
  <tr>
    <td><?=$key?></td>
    <td><?=$key_data['type_str']?></td>
    <td>
      <?=($key_data['hits'] ? $key_data['hits'] : '-' )?>
    </td>
  </tr>
  <? endforeach; ?>
</table>
