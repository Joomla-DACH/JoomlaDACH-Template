<?php

/**
 * @package         Joomla.Site
 * @subpackage      Template.system
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license         GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\ErrorDocument $this */

if (!isset($this->error))
{
    $this->error = new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
    $this->debug = false;
}

// Load template CSS file

// Set page title
$this->setTitle($this->error->getCode() . ' - ' . htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'));

$this->getWebAssetManager()->registerAndUseStyle(
    'template', 'templates/' . $this->template . '/assets/css/template.css'
);
$this->getWebAssetManager()->registerAndUseScript('aos', 'templates/' . $this->template . '/assets/js/aos.js', [],
    ['async' => true], []);
$this->getWebAssetManager()->registerAndUseScript(
    'template', 'templates/' . $this->template . '/assets/js/template.js', [], ['defer' => true], []
);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas"/>
    <jdoc:include type="styles"/>
    <jdoc:include type="scripts"/>
    <?php if (empty($_SERVER['HTTP_X_INLINE_STYLES']) || $_SERVER['HTTP_X_INLINE_STYLES'] !== 'false'): ?>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . "/assets/css/critical.css"); ?>
        </style>
    <?php else: ?>
        <link href="<?php echo 'templates/' . $this->template . '/assets/css/critical.css?v=' . md5(
                file_get_contents(dirname(__FILE__) . "/assets/css/critical.css")
            ); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>
</head>
<body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?>">
<header class="headerbar">
</header>
<main class="errorpage">
  <div class="error">
    <div id="outline">
      <div id="errorboxoutline">
        <div id="errorboxheader"><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></div>
        <div id="errorboxbody">
          <p><strong><?php echo Text::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
          <ol>
            <li><?php echo Text::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
            <li><?php echo Text::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
            <li><?php echo Text::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
            <li><?php echo Text::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
            <li><?php echo Text::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
            <li><?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
          </ol>
          <p><strong><?php echo Text::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>
          <ul>
            <li><a href="<?php echo Uri::root(true); ?>/index.php"><?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></li>
          </ul>
          <p><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
          <div id="techinfo">
            <p>
                <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
                <?php if ($this->debug) : ?>
                  <br><?php echo htmlspecialchars($this->error->getFile(), ENT_QUOTES, 'UTF-8');?>:<?php echo $this->error->getLine(); ?>
                <?php endif; ?>
            </p>
              <?php if ($this->debug) : ?>
                <div>
                    <?php echo $this->renderBacktrace(); ?>
                    <?php // Check if there are more Exceptions and render their data as well ?>
                    <?php if ($this->error->getPrevious()) : ?>
                        <?php $loop = true; ?>
                        <?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
                        <?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
                        <?php $this->setError($this->_error->getPrevious()); ?>
                        <?php while ($loop === true) : ?>
                        <p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                        <p>
                            <?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
                          <br><?php echo htmlspecialchars($this->_error->getFile(), ENT_QUOTES, 'UTF-8');?>:<?php echo $this->_error->getLine(); ?>
                        </p>
                            <?php echo $this->renderBacktrace(); ?>
                            <?php $loop = $this->setError($this->_error->getPrevious()); ?>
                        <?php endwhile; ?>
                        <?php // Reset the main error object to the base error ?>
                        <?php $this->setError($this->error); ?>
                    <?php endif; ?>
                </div>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<footer class="footer">
</footer>
<jdoc:include type="modules" name="debug"/>
<jdoc:include type="styles"/>
</body>
</html>
