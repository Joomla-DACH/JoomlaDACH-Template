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

$uri = \Joomla\CMS\Uri\Uri::getInstance();

?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="scripts" />
    <style>
      <?php echo file_get_contents(dirname(__FILE__) . "/assets/css/critical.css"); ?>
    </style>
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo $templatePath . '/favicon_package'; ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo $templatePath . '/favicon_package'; ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo $templatePath . '/favicon_package'; ?>/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $templatePath . '/favicon_package'; ?>/site.webmanifest">
    <meta name="msapplication-TileColor" content="#1c243e">
    <meta name="theme-color" content="#ffffff">

    <link href="https://www.joomla.de<?php echo $uri->toString(['path', 'query', 'fragment']); ?>" rel="alternate" hreflang="de-de" />
    <link href="https://www.joomla.at<?php echo $uri->toString(['path', 'query', 'fragment']); ?>" rel="alternate" hreflang="de-at" />
    <link href="https://www.joomla.ch<?php echo $uri->toString(['path', 'query', 'fragment']); ?>" rel="alternate" hreflang="de-ch" />
  </head>
  <body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?>">
    <header class="headerbar">
      <div class="headerbar__content contentcontainer">
        <div class="headerbar__content-mainbar">
          <div class="headerbar__content-logomark">
            <a href="<?php echo $this->baseurl ?>">
              <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/assets/img/logomark.svg" width="47" height=47" alt="Zur Startseite" />
            </a>
          </div>
          <button class="headerbar__content-navtoggler">
            <span class="visuallyhidden">Menü anzeigen / ausblenden</span>
            <span aria-hidden="true" class="headerbar__content-navtoggler-icon">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </button>
          <?php if ($this->countModules('header_mainnav', true)) : ?>
            <nav class="headerbar__content-mainnav">
              <jdoc:include type="modules" name="header_mainnav" />
                <?php if ($this->countModules('header_secnav', true)) : ?>
                  <div class="headerbar__content-mainnav-secnav secnav">
                    <jdoc:include type="modules" name="header_secnav" />
                  </div>
                <?php endif; ?>
            </nav>
          <?php endif; ?>
        </div>
        <?php if ($this->countModules('header_secnav', true)) : ?>
          <nav class="headerbar__content-secnav secnav">
            <jdoc:include type="modules" name="header_secnav" />
          </nav>
        <?php endif; ?>
      </div>
    </header>
    <main>
      <div class="main__content">
        <?php if ($this->countmodules('content_top_fullwidth', true)) :  ?>
          <jdoc:include type="modules" name="content_top_fullwidth"/>
        <?php endif; ?>
        <div class="contentcontainer">
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
        <?php if ($this->countmodules('content_bottom_fullwidth', true)) :  ?>
          <jdoc:include type="modules" name="content_bottom_fullwidth"/>
        <?php endif; ?>
      </div>
    </main>
    <footer class="footer">
      <div class="footer__main bg-midblue">
          <div class="contentcontainer">
              <?php if ($this->countModules('footer_nav', true)) : ?>
                <nav class="footer__main-nav">
                  <jdoc:include type="modules" name="footer_nav" />
                </nav>
              <?php endif; ?>
              <?php if ($this->countModules('footer_content', true)) : ?>
                <nav class="footer__main-content">
                  <jdoc:include type="modules" name="footer_content" />
                </nav>
              <?php endif; ?>
          </div>
      </div>
      <div class="footer__bottom bg-darkblue">
        <div class="contentcontainer">
          <span class="footer__bottom-copyrightnote">
          © <?php echo date("Y"); ?> JandBeyond e.V. – die Joomla!-Vereine aus Deutschland, Österreich und der Schweiz
        </span>
            <?php if ($this->countModules('footer_bottomnav', true)) : ?>
              <nav class="footer__bottom-nav">
                <jdoc:include type="modules" name="footer_bottomnav" />
              </nav>
            <?php endif; ?>
        </div>
      </div>
    </footer>
    <jdoc:include type="modules" name="debug" />
    <jdoc:include type="styles" />
    <a rel="me" href="https://joomla.social/@joomla_de" style="display:none;">Mastodon</a>
  </body>
</html>
