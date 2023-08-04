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

<div class="accordion">
    <?php $i = 1; ?>
    <?php foreach ($list as $item) : ?>
      <div class="accordion__item">
        <button type="button" aria-expanded="false" class="accordion__item-trigger"
                aria-controls="sect<?php echo $i; ?>" id="accordion<?php echo $i; ?>id">
              <span class="accordion__item-trigger-title" id="title<?php echo $i; ?>">
                        <?php echo $item->title; ?>
              </span>
          <svg class="accordion__item-trigger-icon" xmlns="http://www.w3.org/2000/svg" width="18.214" height="31.629"
               viewBox="0 0 18.214 31.629">
            <path d="M417.213,197.147,407.7,186.863,399,197.147h5.464v21.344h7.283V197.147Z"
                  transform="translate(417.213 218.492) rotate(180)" fill="currentColor" />
          </svg>
        </button>
        <div id="sect<?php echo $i; ?>" role="region" aria-labelledby="title<?php echo $i; ?>" class="accordion__item-panel">
            <?php echo $item->introtext; ?>
        </div>
      </div>
      <?php $i++; ?>
    <?php endforeach; ?>
</div>
