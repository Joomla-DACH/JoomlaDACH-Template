<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<dd class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
    <?php $author = ($displayData['item']->created_by_alias ?: $displayData['item']->author); ?>
    <?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
    <?php if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author') == true) : ?>
        <?php echo HTMLHelper::_('link', $displayData['item']->contact_link, $author, ['itemprop' => 'url']); ?>
    <?php else : ?>
        <?php echo $author; ?>
    <?php endif; ?>
</dd>
