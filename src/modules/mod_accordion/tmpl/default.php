<?php

/**
 * @version    CVS: 1.0.0
 * @package    Mod_Grevenheader
 * @author     djumla GmbH, Lukas Jardin <info@djumla.de>
 * @copyright  2018 djumla GmbH
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

$randomId = substr(md5(uniqid()), 0, 12);
?>

<div id="accordion-<?php echo $randomId; ?>class="accordion  <?php echo json_decode($module->params)->moduleclass_sfx ; ?>">
    <?php $i = 1; ?>
    <?php foreach($params->get('items') as $item): ?>
      <div class="accordion__item">
        <button type="button" aria-expanded="false" class="accordion__item-trigger"
                aria-controls="sect<?php echo $randomId . $i; ?>" id="accordion<?php echo $randomId . $i; ?>id">
            <span class="accordion__item-trigger-title" id="title<?php echo $randomId . $i; ?>">
                      <?php echo $item->item_title; ?>
            </span>
          <svg class="accordion__item-trigger-icon" xmlns="http://www.w3.org/2000/svg" width="18.214" height="31.629"
               viewBox="0 0 18.214 31.629">
            <path d="M417.213,197.147,407.7,186.863,399,197.147h5.464v21.344h7.283V197.147Z"
                  transform="translate(417.213 218.492) rotate(180)" fill="currentColor" />
          </svg>
        </button>
        <div id="sect<?php echo $randomId . $i; ?>" role="region" aria-labelledby="title<?php echo $randomId . $i; ?>" class="accordion__item-panel">
            <?php echo $item->item_content; ?>
        </div>
      </div>
      <?php $i++; ?>
    <?php endforeach; ?>
</div>