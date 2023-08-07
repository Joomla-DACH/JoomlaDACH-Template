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
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;

$doc = Factory::getApplication()->getDocument();
$wa = $doc->getWebAssetManager();
$wa->registerAndUseScript('tabs', 'media/mod_tabs/js/mod_tabs.js', [], ['defer' => true], []);

PluginHelper::importPlugin('content');

$randomId = substr(md5(uniqid()), 0, 12);
?>


<div class="tabs">
  <div role="tablist" class="automatic tabs__tablist">
    <?php $navindex = 1; ?>
    <?php foreach($params->get('items') as $item): ?>
      <button id="tab-<?php echo $navindex; ?>" type="button" role="tab" aria-selected="<?php echo $navindex === 1 ? 'true' : 'false' ;?>" aria-controls="tabpanel-<?php echo $randomId . $navindex; ?>" <?php echo $navindex > 1 ? 'tabindex="-1"' : '' ; ?>>
        <?php echo $item->item_title; ?>
      </button>
      <?php $navindex++; ?>
    <?php endforeach; ?>
  </div>
  <div class="tabs__panels">
    <?php $panelindex = 1; ?>
      <?php foreach($params->get('items') as $item): ?>
        <div id="tabpanel-<?php echo $randomId . $panelindex; ?>" role="tabpanel" tabindex="0" aria-labelledby="tab-<?php echo $panelindex; ?>">
            <?php
            $content = HTMLHelper::_('content.prepare', $item->item_content, '', 'mod_tabs.content');
            echo $content;
            ?>
        </div>
        <?php $panelindex++; ?>
    <?php endforeach; ?>
  </div>
</div>