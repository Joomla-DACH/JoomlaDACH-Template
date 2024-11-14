<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles
 *
 * @copyright   (C) 2024 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->useScript('joomla.dialog-autocreate');

if (!$list) {
	return;
}

$items = $list;
$today = Factory::getDate()->format('Y-m-d');

// Set up the modal options that will be used for module editor
$popupOptions = [
	'popupType'  => 'iframe',
	'className'  => 'adventskalender',
];
?>

<div class="advent-grid advent-bg">
	<?php foreach ($items as $item) : ?>
		<?php
		$images  = json_decode($item->images);
		$layoutAttr = [
			'src' => $images->image_intro,
			'alt' => empty($images->image_intro_alt) ? '' : $images->image_intro_alt,
		];

		// Get the custom fields for this article
		$jcfields = FieldsHelper::getFields('com_content.article', $item, true);

		// Create an associative array for easier access by field name
		foreach($jcfields as $jcfield) {
			$jcfields[$jcfield->name] = $jcfield;
		}

		// Ensure the adventdate field exists and is a valid date
		$adventDate = isset($jcfields['adventdate']) ? date('Y-m-d', strtotime($jcfields['adventdate']->value)) : null;

		// Set up popup options
		$popupOptions['src'] = Route::_('index.php?view=article&layout=modal&tmpl=component&id=' . $item->id, false);
		$popupOptions['textHeader'] = $item->title;
		?>

        <div class="mod-articles-advent-item-content">
			<?php if ($adventDate && $adventDate <= $today) : ?>
                <button type="button"
                        data-joomla-dialog="<?php echo htmlspecialchars(json_encode($popupOptions, JSON_UNESCAPED_SLASHES)) ?>"
                        class="btn btn-link advent-link"
                        aria-label="Öffnet <?php echo $item->title; ?>"
                        id="title-<?php echo $item->id; ?>"
                        data-module-id="<?php echo $item->id; ?>">
                    <span><?php echo date('j', strtotime($adventDate)); ?></span>
                </button>
			<?php else : ?>
                <span><?php echo date('j', strtotime($adventDate)); ?></span>
			<?php endif; ?>
        </div>
	<?php endforeach; ?>
</div>
