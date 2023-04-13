<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

// Use Asset Manager
$templatePath = 'templates/' . $this->template;
$wa  = $this->getWebAssetManager();

$wa->registerAndUseStyle('template', $templatePath . '/assets/css/template.css');
$wa->registerAndUseScript('template', $templatePath . '/assets/js/template.js', [], ['defer' => true], []);

// Load Pageclass
$app = Factory::getApplication();
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Generator tag
$this->setGenerator(null);

// Add Meta Information
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="scripts" />
    <?php if(empty($_SERVER['HTTP_X_INLINE_STYLES']) || $_SERVER['HTTP_X_INLINE_STYLES'] !== 'false'): ?>
      <style>
        <?php echo file_get_contents(dirname(__FILE__) . "/assets/css/critical.css"); ?>
      </style>
    <?php else: ?>
      <link href="<?php echo 'templates/' . $this->template . '/assets/css/critical.css?v=' . md5(file_get_contents(dirname(__FILE__) . "/assets/css/critical.css")); ?>" rel="stylesheet" type="text/css" />
    <?php endif; ?>
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo $templatePath . '/favicon_package'; ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo $templatePath . '/favicon_package'; ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo $templatePath . '/favicon_package'; ?>/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $templatePath . '/favicon_package'; ?>/site.webmanifest">
    <meta name="msapplication-TileColor" content="#1c243e">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?>">
    <header class="headerbar">
      <div class="contentcontainer">
    </header>
    <main>
      <div class="main__content">
          <?php if ($this->countmodules('content_top', true)) :  ?>
            <jdoc:include type="modules" name="content_top"/>
          <?php endif; ?>
          <jdoc:include type="message" />
          <?php if( strpos( $pageclass, 'hidecomponent' ) === false) : ?>
            <jdoc:include type="component" />
          <?php endif; ?>
          <?php if ($this->countmodules('content_bottom', true)) :  ?>
            <jdoc:include type="modules" name="content_bottom" />
          <?php endif; ?>
      </div>
    </main>
    <footer class="footer">
    </footer>
    <jdoc:include type="modules" name="debug" />
    <jdoc:include type="styles" />
  </body>
</html>
