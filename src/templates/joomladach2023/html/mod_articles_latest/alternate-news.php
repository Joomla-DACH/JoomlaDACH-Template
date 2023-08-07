<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;

if (!$list) {
    return;
}

?>

<div class="mod-articles-latest-alternate mod-articles-latest-alternate--news">
    <?php foreach ($list as $item) : ?>
      <div class="mod-articles-latest-alternate__item">
        <div class="mod-articles-latest-alternate__item-content">
          <span class="txt-lightgrey txt-sm"><?php echo JFactory::getDate($item->publish_up)->format('d.m.Y'); ?></span>
          <h3 class=" mod-articles-latest-alternate__item-content-title"><?php echo $item->title; ?></h3>
          <div class="mod-articles-latest-alternate__item-content-introtext">
              <?php echo $item->introtext; ?>
          </div>
          <a class="arrowlink" href="<?php echo $item->link ;?>"><?php echo JText::_('COM_CONTENT_READ_MORE'); ?></a>
        </div>
      </div>
    <?php endforeach; ?>
</div>
