<p>
  <a href="<?=ROOT_URL?>" class="btn btn-success">Back to home</a>
</p>

<table class="table table-condensed table-bordered">
  <tr>
    <th>Key</th>
    <th>Value</th>
  </tr>
  <? foreach($infos as $key => $value): ?>
  <tr>
    <td><?=$key?></td>
    <td><?=$value?></td>
  </tr>
  <? endforeach; ?>
</table>
