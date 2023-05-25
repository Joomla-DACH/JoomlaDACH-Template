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

<div class="tabs modul__accordion-faq">
    <?php $i = 1; ?>
<?php foreach ($list as $item) : ?>
    <h3>
    <button type="button" aria-expanded="false" class="modul__accordion-faq_trigger" aria-controls="sect<?php echo $i; ?>" id="accordion<?php echo $i; ?>id">
      <span class="modul__accordion-faq_title">
                <?php echo $item->title; ?>

      </span>
        <svg class="modul__accordion-faq_icon" xmlns="http://www.w3.org/2000/svg" width="18.214" height="31.629" viewBox="0 0 18.214 31.629">
            <path id="Pfad_165" data-name="Pfad 165" d="M417.213,197.147,407.7,186.863,399,197.147h5.464v21.344h7.283V197.147Z" transform="translate(417.213 218.492) rotate(180)" fill="currentColor"/>
        </svg>
    </button>
    </h3>
    <div id="sect<?php echo $i; ?>" role="region" aria-labelledby="accordion1id" class="modul__accordion-faq_panel" hidden>
        <div>
            <?php echo $item->introtext; ?>
        </div>
    </div>
    <?php $i++; ?>
<?php endforeach; ?>
</div>
