<?php


// No direct access
defined('_JEXEC') or die;
?>

<div class="bg-<?php echo $params->get('background'); ?> imagetext imagewidth-<?php echo $params->get('imagewidth'); ?> imagealignment-<?php echo $params->get('imagealignment'); ?> mobileimageplacement-<?php echo $params->get('mobileimageplacement'); ?>">
  <div class="imagetext__imagecontainer">
    <picture>
      <source srcset="<?php echo $params->get('image-mobile'); ?>" media="(max-width: 767px)" />
      <img src="<?php echo $params->get('image'); ?>" alt="" />
    </picture>
  </div>
  <div class="imagetext__contentcontainer">
    <div class="imagetext__contentcontainer-content">
        <?php echo $params->get('content'); ?>
    </div>
    <div class="imagetext__contentcontainer-ctas">
        <?php foreach($params->get('ctas') as $item): ?>
          <a href="<?php echo $item->item_link; ?>" class="btn btn--<?php echo $item->item_variant; ?>">
              <?php echo $item->item_label; ?>
          </a>
        <?php endforeach; ?>
    </div>
  </div>
</div>