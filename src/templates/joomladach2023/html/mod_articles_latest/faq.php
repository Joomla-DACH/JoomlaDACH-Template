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

<div class="tabs modul__akkordion-faq">
    <?php $i = 1; ?>
<?php foreach ($list as $item) : ?>
    <div class="modul__akkordion-faq_tab">
        <input class="modul__akkordion-faq_radio" type="radio" id="rd<?php echo $i; ?>" name="rd">
        <label class="modul__akkordion-faq_tab-label" for="rd<?php echo $i; ?>" itemscope itemtype="https://schema.org/Article">
            <span itemprop="name">
                <?php echo $item->title; ?>
            </span>
        </label>
        <div class="modul__akkordion-faq_tab-content">
            <?php echo $item->introtext; ?>
        </div>
    </div>
    <?php $i++; ?>
<?php endforeach; ?>
</div>
