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
?>

<div class="jdachhero bg-<?php echo $params->get('background'); ?>">
  <div class="jdachhero__content contentcontainer">
      <h1><?php echo $params->get('title'); ?></h1>
      <div class="jdachhero__content-ctas">
          <?php foreach($params->get('ctas') as $item): ?>
            <a href="<?php echo $item->item_link; ?>" class="btn btn--<?php echo $item->item_variant; ?>">
                <?php echo $item->item_label; ?>
            </a>
          <?php endforeach; ?>
      </div>
  </div>
  <img src="<?php echo $params->get('image'); ?>" class="jdachhero__image" />
</div>
