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

<div class="mod-articles-latest-alternate mod-articles-latest-alternate--counter">
    <?php foreach ($list as $item) : ?>
      <div class="mod-articles-latest-alternate__item">
        <div class="mod-articles-latest-alternate__item-content">
          <h3 class="h2 mod-articles-latest-alternate__item-content-title"><?php echo $item->title; ?></h3>
          <div class="mod-articles-latest-alternate__item-content-introtext">
              <?php echo $item->introtext; ?>
          </div>
        </div>
          <?php if(!empty(json_decode($item->images)->image_intro)): ?>
            <?php
              $img = HTMLHelper::_('cleanImageURL', json_decode($item->images)->image_intro);
            ?>
            <img
              src="<?php echo $img->url ;?>"
              loading="lazy"
              alt="<?php echo $item->title; ?>"
              class="mod-articles-latest-alternate__item-image"
              width="<?php echo $img->attributes['width']; ?>"
              height="<?php echo $img->attributes['height']; ?>"
            />
          <?php endif; ?>
      </div>
    <?php endforeach; ?>
</div>
