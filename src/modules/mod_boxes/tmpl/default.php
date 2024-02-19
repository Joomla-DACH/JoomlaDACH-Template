<?php


// No direct access
defined('_JEXEC') or die;
?>

<div class="grid grid--col<?php echo $params->get('columns') ;?> <?php echo json_decode($module->params)->moduleclass_sfx ; ?>">
    <?php foreach($params->get('items') as $item): ?>
      <div class="card bg-<?php echo $item->item_background; ?>">
        <div class="card__contentcontainer">
          <span class="card__title">
            <?php echo $item->item_title; ?>
          </span>
          <?php if(!empty($item->item_content)): ?>
            <div class="card__content">
                <?php echo $item->item_content; ?>
            </div>
          <?php endif; ?>
        </div>
        <a href="<?php echo $item->item_link; ?>" class="card__link <?php echo $item->item_linktype == 'download' ? 'downloadlink' : 'arrowlink';?>">
            <?php echo $item->item_linklabel; ?>
        </a>
      </div>
    <?php endforeach; ?>
 </div>