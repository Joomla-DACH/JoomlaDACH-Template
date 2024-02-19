<?php


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
