<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2014 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$item    = $displayData['data'];
$display = $item->text;
$app = Factory::getApplication();

switch ((string) $item->text) {
    // Check for "Start" item
    case Text::_('JLIB_HTML_START'):
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28.608" height="14.277" viewBox="0 0 28.608 14.277"><path id="Pfad_180" data-name="Pfad 180" d="M413.276,191.081l-6.966-12.156L399,191.081h4.283v16.452h5.709V191.081Z" transform="translate(207.534 -398.999) rotate(90)" fill="currentColor"/></svg>';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "Prev" item
    case $item->text === Text::_('JPREV'):
        $item->text = Text::_('JPREVIOUS');
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28.608" height="14.277" viewBox="0 0 28.608 14.277"><path id="Pfad_180" data-name="Pfad 180" d="M413.276,191.081l-6.966-12.156L399,191.081h4.283v16.452h5.709V191.081Z" transform="translate(207.534 -398.999) rotate(90)" fill="currentColor"/></svg>';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "Next" item
    case Text::_('JNEXT'):
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28.608" height="14.277" viewBox="0 0 28.608 14.277"><path id="Pfad_180" data-name="Pfad 180" d="M413.276,191.081l-6.966-12.156L399,191.081h4.283v16.452h5.709V191.081Z" transform="translate(207.534 -398.999) rotate(90)" fill="currentColor"/></svg>';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "End" item
    case Text::_('JLIB_HTML_END'):
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28.608" height="14.277" viewBox="0 0 28.608 14.277"><path id="Pfad_180" data-name="Pfad 180" d="M413.276,191.081l-6.966-12.156L399,191.081h4.283v16.452h5.709V191.081Z" transform="translate(207.534 -398.999) rotate(90)" fill="currentColor"/></svg>';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    default:
        $icon = null;
        $aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', strtolower($item->text));
        break;
}

if ($icon !== null) {
    $display = '<span class="icon" aria-hidden="true">' . $icon . '</span>';
}

if ($displayData['active']) {
    if ($item->base > 0) {
        $limit = 'limitstart.value=' . $item->base;
    } else {
        $limit = 'limitstart.value=0';
    }

    $class = 'active';

    if ($app->isClient('administrator')) {
        $link = 'href="#" onclick="document.adminForm.' . $item->prefix . $limit . '; Joomla.submitform();return false;"';
    } elseif ($app->isClient('site')) {
        $link = 'href="' . $item->link . '"';
    }
} else {
    $class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
}

?>
<?php if ($displayData['active']) : ?>
    <li class="page-item">
        <a aria-label="<?php echo $aria; ?>" <?php echo $link; ?> class="page-link">
            <?php echo $display; ?>
        </a>
    </li>
<?php elseif (isset($item->active) && $item->active) : ?>
    <?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', strtolower($item->text)); ?>
    <li class="<?php echo $class; ?> page-item">
        <a aria-current="true" aria-label="<?php echo $aria; ?>" href="#" class="page-link"><?php echo $display; ?></a>
    </li>
<?php else : ?>
    <li class="<?php echo $class; ?> page-item">
        <span class="page-link" aria-hidden="true"><?php echo $display; ?></span>
    </li>
<?php endif; ?>
