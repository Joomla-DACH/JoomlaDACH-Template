<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$direction = Factory::getLanguage()->isRtl() ? 'left' : 'right';

/** @var \Joomla\Component\Contact\Site\View\Contact\HtmlView $this */
?>
<?php if ($this->params->get('show_articles')) : ?>
    <div class="com-contact__articles contact-articles">
    <?php foreach ($this->item->articles as $article) : ?>
        <?php
            $images  = json_decode($article->images);
            $layoutAttr = [
                'src' => $images->image_intro,
                'alt' => empty($images->image_intro_alt) && empty($images->image_intro_alt_empty) ? false : $images->image_intro_alt,
            ];
        ?>
        <div class="contact-article">
            <?php if (!empty($images->image_intro)) : ?>
                <div class="contact-image">
                    <?php echo LayoutHelper::render('joomla.html.image', array_merge($layoutAttr, ['itemprop' => 'thumbnail'])); ?>
                </div>
            <?php endif; ?>
            <div class="contact-content">
                <time class="article-date" datetime="<?php echo HTMLHelper::_('date', $article->publish_up, 'c'); ?>" itemprop="datePublished">
                    <?php echo Text::sprintf(HTMLHelper::_('date', $article->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
                </time>

                <h3 class="article-title" itemprop="name">
                    <?php echo HTMLHelper::_('link', Route::_(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language)), $this->escape($article->title)); ?>
                </h3>

                <?php echo $article->introtext; ?>

                <a class="readmore arrowlink" href="<?php echo Route::_(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language)); ?>" aria-label="<?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($article->title)); ?>">
                    <?php echo Text::_('JGLOBAL_READ_MORE'); ?>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
