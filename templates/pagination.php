<? if($pagination['last_page'] > 1 && $pagination['page'] > 0): ?>
<ul class="breadcrumb">

<? if($pagination['page'] > 1): ?>
  <li><a href="<?=ROOT_URL?>search/<?=urlencode($search)?>/page/<?=($pagination['page']-1)?>"><i class="icon-chevron-left"></i></a></li>
<? endif; ?>

<? for($i = 1; $i <= $pagination['last_page']; $i++): ?>

  <? $dsp_pages = array(1, 2, $pagination['page'] - 1, $pagination['page'], $pagination['page'] + 1, $pagination['last_page'] - 1, $pagination['last_page']); ?>
  <? if(!in_array($i, $dsp_pages)): ?>
    <?=($i == $pagination['page'] - 2 || $i == $pagination['page'] + 2 ? '...' : '')?>
  <? continue; endif; ?>

  <? if($i == $pagination['page']): ?>
  <li class="active"><?=$i?></li>
  <? else: ?>
  <li><a href="<?=ROOT_URL?>search/<?=urlencode($search)?>/page/<?=$i?>"><?=$i?></a></li>
  <? endif; ?>
<? endfor; ?>

<? if($pagination['page'] < $pagination['last_page']): ?>
  <li><a href="<?=ROOT_URL?>search/<?=urlencode($search)?>/page/<?=($pagination['page']+1)?>"><i class="icon-chevron-right"></i></a></li>
<? endif; ?>

  <li>(<?=(($pagination['page']-1)*$pagination['nb_page'])?>-<?=(($pagination['page'])*$pagination['nb_page'])?>/<?=$pagination['total']?>)</li>

  <li><a href="<?=ROOT_URL?>search/<?=urlencode($search)?>/all">View all</a></li>
</ul>
<? endif; ?>

<? if($pagination['page'] == 0): ?>
<p>
  <a class="btn btn-primary" href="<?=ROOT_URL?>search/<?=urlencode($search)?>/page/1">Back to paginated listing</a>
</p>
<? endif; ?>
