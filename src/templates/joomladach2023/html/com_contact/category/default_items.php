<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Contact\Administrator\Helper\ContactHelper;
use Joomla\Component\Contact\Site\Helper\RouteHelper;

/** @var \Joomla\Component\Contact\Site\View\Category\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('core');

$canDo   = ContactHelper::getActions('com_contact', 'category', $this->category->id);
$canEdit = $canDo->get('core.edit');
$userId  = $this->getCurrentUser()->id;

$showEditColumn = false;
if ($canEdit) {
    $showEditColumn = true;
} elseif ($canDo->get('core.edit.own') && !empty($this->items)) {
    foreach ($this->items as $item) {
        if ($item->created_by == $userId) {
            $showEditColumn = true;
            break;
        }
    }
}

$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
?>
<div class="com-contact-category__items columns-2">
    <?php if (empty($this->items)) : ?>
        <?php if ($this->params->get('show_no_contacts', 1)) : ?>
            <div class="alert alert-info">
                <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
                <?php echo Text::_('COM_CONTACT_NO_CONTACTS'); ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <?php foreach ($this->items as $i => $item) : ?>
            <?php if ($this->items[$i]->published == 0) : ?>
                <div class="system-unpublished com-contact-category__item">
            <?php else : ?>
                <div class="com-contact-category__item" >
            <?php endif; ?>
                <?php if ($this->params->get('show_image_heading')) : ?>
                    <?php if ($item->image) : ?>
                        <div class="item-imagecontainer">
                        <?php echo LayoutHelper::render(
                            'joomla.html.image',
                            [
                                'src'   => $item->image,
                                'alt'   => '',
                                'class' => 'contact-thumbnail img-thumbnail',
                            ]
                        ); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="page-header">
                    <h2><?php echo HTMLHelper::_('link', Route::_(RouteHelper::getContactRoute($item->slug, $item->catid, $item->language)), $this->escape($item->name)); ?></h2>
                </div>
                <?php if ($item->published == 0) : ?>
                    <div>
                        <span class="list-published badge bg-warning text-light">
                            <?php echo Text::_('JUNPUBLISHED'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($item->publish_up && strtotime($item->publish_up) > strtotime(Factory::getDate())) : ?>
                    <div>
                        <span class="list-published badge bg-warning text-light">
                            <?php echo Text::_('JNOTPUBLISHEDYET'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if (!is_null($item->publish_down) && strtotime($item->publish_down) < strtotime(Factory::getDate())) : ?>
                    <div>
                        <span class="list-published badge bg-warning text-light">
                            <?php echo Text::_('JEXPIRED'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($item->published == -2) : ?>
                    <div>
                        <span class="badge bg-warning text-light">
                            <?php echo Text::_('JTRASHED'); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php echo $item->event->afterDisplayTitle; ?>

                <?php echo $item->event->beforeDisplayContent; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($this->params->get('show_pagination', 2)) : ?>
        <div class="com-contact-category__pagination w-100">
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="com-contact-category__counter counter float-end pt-3 pe-2">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </p>
            <?php endif; ?>

            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php endif; ?>
</div>
