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

<div class="testimonial">
  <div class="testimonial__content">
    <blockquote class="testimonial__content-quote txt-lg txt-600">
        <?php echo $params->get('quote'); ?>
      <footer class="txt-sm txt-400">
          <?php echo $params->get('subline'); ?>
      </footer>
    </blockquote>
  </div>
  <img src="<?php echo $params->get('image'); ?>" class="testimonial__image" />
</div>
