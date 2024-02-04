<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create a shortcut for params.
$params = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
    || ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);

$customFields = $this->item->jcfields;
foreach ($customFields as $customField)
{
    $customFields[$customField->name] = $customField;
}

?>

<!-- Set Readmore Link -->
<?php if ($this->item->readmore) :
    if ($params->get('access-view')) :
        $link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
    else :
        $menu = Factory::getApplication()->getMenu();
        $active = $menu->getActive();
        $itemId = $active->id;
        $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
        $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
    endif; ?>
<?php endif; ?>

<a class="item-imagecontainer" href="<?php echo $link; ?>">
    <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
</a>
<div class="item-content">
    <?php if ($isUnpublished) : ?>
        <div class="system-unpublished">
    <?php endif; ?>
    <div class="item-content__text">
        <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
        <?php if ($canEdit) : ?>
            <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $params, 'item' => $this->item]); ?>
        <?php endif; ?>

        <?php // @todo Not that elegant would be nice to group the params ?>
        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
            || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

        <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
            <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'above']); ?>
        <?php endif; ?>
        <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
        <?php endif; ?>

        <?php if (!$params->get('show_intro')) : ?>
            <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
            <?php echo $this->item->event->afterDisplayTitle; ?>
        <?php endif; ?>

        <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
        <?php echo $this->item->event->beforeDisplayContent; ?>

        <p class="txt-lightgrey txt-sm">
            <?php echo $customFields['plz']->value; ?> <?php echo $customFields['ort']->value; ?>,
            <?php foreach (["region-de", "region-at", "region-ch"] as $region): ?>
                <?php if ($customFields[$region]->value): ?>
                    <?php echo explode(",", reset($customFields[$region]->rawvalue))[1]; break; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </p>

        <?php echo $this->item->introtext; ?>

        <?php if(!empty($customFields['taetigkeitsbereich']->rawvalue)): ?>
        <ul class="serviceproviderdirectory__item-areasofexpertise">
            <?php foreach ($customFields['taetigkeitsbereich']->rawvalue as $area): ?>
              <li class="areasofexpertise__item btn btn-sm">
                <?php echo $area; ?>
              </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if ($info == 1 || $info == 2) : ?>
            <?php if ($useDefList) : ?>
                <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'below']); ?>
            <?php endif; ?>
            <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="serviceproviderdirectory__item-links">
        <a class="btn btn-primary serviceproviderdirectory__item-link" href="<?php echo Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>">Details</a>
        <?php if ($customFields['website']->value): ?>
          <a class="btn btn-primary serviceproviderdirectory__item-link" href="<?php echo $customFields['website']->rawvalue; ?>">Zur Website</a>
        <?php endif; ?>
    </div>

    <?php if ($isUnpublished) : ?>
        </div>
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
    <?php echo $this->item->event->afterDisplayContent; ?>
</div>
