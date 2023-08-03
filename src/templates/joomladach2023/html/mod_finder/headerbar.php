<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_finder
 *
 * @copyright   (C) 2011 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Module\Finder\Site\Helper\FinderHelper;

// Load the smart search component language file.
$lang = $app->getLanguage();
$lang->load('com_finder', JPATH_SITE);

$input = '<input type="text" name="q" id="mod-finder-searchword' . $module->id . '" class="js-finder-search-query form-control" value="' . htmlspecialchars($app->getInput()->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"'
    . ' placeholder="' . Text::_('MOD_FINDER_SEARCH_VALUE') . '">';

$showLabel  = $params->get('show_label', 1);
$labelClass = (!$showLabel ? 'visually-hidden ' : '') . 'finder';
$label      = '<label for="mod-finder-searchword' . $module->id . '" class="' . $labelClass . '">' . $params->get('alt_label', Text::_('JSEARCH_FILTER_SUBMIT')) . '</label>';

$output = '';

if ($params->get('show_button', 0)) {
    $output .= $label;
    $output .= '<div class="mod-finder__search input-group">';
    $output .= $input;
    $output .= '<button class="btn btn-primary" type="submit"><span class="icon-search icon-white" aria-hidden="true"></span> ' . Text::_('JSEARCH_FILTER_SUBMIT') . '</button>';
    $output .= '</div>';
} else {
    $output .= $label;
    $output .= $input;
}

Text::script('MOD_FINDER_SEARCH_VALUE');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_finder');

/*
 * This segment of code sets up the autocompleter.
 */
if ($params->get('show_autosuggest', 1)) {
    $wa->usePreset('awesomplete');
    $app->getDocument()->addScriptOptions('finder-search', ['url' => Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component', false)]);

    Text::script('JLIB_JS_AJAX_ERROR_OTHER');
    Text::script('JLIB_JS_AJAX_ERROR_PARSE');
}

$wa->useScript('com_finder.finder');

?>
<div class="modfinderheaderbar">
  <button type="button" class="btn modfinderheaderbar__toggle">
    <span class="visually-hidden">Suche einblenden</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="33.217" height="30.432" viewBox="0 0 33.217 30.432">
      <g id="Gruppe_152" data-name="Gruppe 152" transform="translate(0 0)">
        <g id="Pfad_3" data-name="Pfad 3" fill="none">
          <path d="M12.222,0A12.222,12.222,0,1,1,0,12.222,12.222,12.222,0,0,1,12.222,0Z" stroke="none"/>
          <path d="M 12.22219944000244 3 C 7.137060165405273 3 3 7.137060165405273 3 12.22219944000244 C 3 17.30733871459961 7.137060165405273 21.44439888000488 12.22219944000244 21.44439888000488 C 17.30733871459961 21.44439888000488 21.44439888000488 17.30733871459961 21.44439888000488 12.22219944000244 C 21.44439888000488 7.137060165405273 17.30733871459961 3 12.22219944000244 3 M 12.22219944000244 0 C 18.97233009338379 0 24.44439888000488 5.472068786621094 24.44439888000488 12.22219944000244 C 24.44439888000488 18.97233009338379 18.97233009338379 24.44439888000488 12.22219944000244 24.44439888000488 C 5.472068786621094 24.44439888000488 0 18.97233009338379 0 12.22219944000244 C 0 5.472068786621094 5.472068786621094 0 12.22219944000244 0 Z" stroke="none" fill="#fff"/>
        </g>
        <line id="Linie_4" data-name="Linie 4" x2="11.543" y2="9.676" transform="translate(20.71 19.606)" fill="none" stroke="#fff" stroke-width="3"/>
      </g>
    </svg>
  </button>
  <form class="modfinderheaderbar__form mod-finder js-finder-searchform form-search" action="<?php echo Route::_($route); ?>" method="get" role="search">
      <?php echo $output; ?>

      <?php $show_advanced = $params->get('show_advanced', 0); ?>
      <?php if ($show_advanced == 2) : ?>
        <br>
        <a href="<?php echo Route::_($route); ?>" class="mod-finder__advanced-link"><?php echo Text::_('COM_FINDER_ADVANCED_SEARCH'); ?></a>
      <?php elseif ($show_advanced == 1) : ?>
        <div class="mod-finder__advanced js-finder-advanced">
            <?php echo HTMLHelper::_('filter.select', $query, $params); ?>
        </div>
      <?php endif; ?>
      <?php echo FinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>
  </form>
</div>

