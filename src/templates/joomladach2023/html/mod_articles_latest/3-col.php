<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

if (!$list) {
    return;
}

?>

<div class="mod-articles-latest-columns mod-articles-latest-columns grid--col3">
    <?php foreach ($list as $item) : ?>
      <a  href="<?php echo $item->link ;?>" class="mod-articles-latest-columns__item">
        <?php if(!empty(json_decode($item->images)->image_intro)): ?>
          <?php
            $img = HTMLHelper::_('cleanImageURL', json_decode($item->images)->image_intro);
          ?>
          <img
            src="<?php echo $img->url ;?>"
            loading="lazy"
            alt="<?php echo $item->title; ?>"
            class="mod-articles-latest-columns__item-image"
            width="<?php echo $img->attributes['width']; ?>"
            height="<?php echo $img->attributes['height']; ?>"
          />
        <?php endif; ?>
        <div class="mod-articles-latest-columns__item-content">
          <h3 class=" mod-articles-latest-columns__item-content-title"><?php echo $item->title; ?></h3>
          <span class="txt-lightgrey txt-sm"><?php echo JFactory::getDate($item->publish_up)->format('d.m.Y'); ?> <?php echo $item->author ;?></span>
          <div class="mod-articles-latest-columns__item-content-introtext">
              <?php echo $item->introtext; ?>
          </div>
          <span class="arrowlink"><?php echo JText::_('COM_CONTENT_READ_MORE'); ?></span>
        </div>
      </a>
    <?php endforeach; ?>
</div>
