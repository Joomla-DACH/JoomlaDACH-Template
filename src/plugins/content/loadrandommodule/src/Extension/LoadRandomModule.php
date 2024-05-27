<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.loadmodule
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace JoomlaDACH\Plugin\Content\LoadRandomModule\Extension;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Plugin\CMSPlugin;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Plugin to enable loading modules into content (e.g. articles)
 * This uses the {loadmodule} syntax
 *
 * @since  1.5
 */
final class LoadRandomModule extends CMSPlugin
{
    protected static $modules = [];

    protected static $mods = [];

    /**
     * Plugin that loads module positions within content
     *
     * @param   string   $context   The context of the content being passed to the plugin.
     * @param   object   &$article  The article object.  Note $article->text is also available
     * @param   mixed    &$params   The article params
     * @param   integer  $page      The 'page' number
     *
     * @return  void
     *
     * @since   1.6
     */
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        // Only execute if $article is an object and has a text property
        if (!\is_object($article) || !property_exists($article, 'text') || \is_null($article->text)) {
            return;
        }

        // Expression to search for (positions)
        $regex = '/{loadrandommodule\s(.*?)}/i';

        // Remove macros and don't run this plugin when the content is being indexed
        if ($context === 'com_finder.indexer') {
            if (str_contains($article->text, 'loadrandommodule')) {
                $article->text = preg_replace($regex, '', $article->text);
            }

            return;
        }

        if (!str_contains($article->text, '{loadrandommodule '))
        {
            return;
        }

        // Find all instances of plugin and put in $matches for loadposition
        // $matches[0] is full pattern match, $matches[1] is the position
        preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

        // No matches, skip this
        if ($matches) {
            foreach ($matches as $match) {
                $position = $match[1];

                $output = $this->load($position);

                // We should replace only first occurrence in order to allow positions with the same name to regenerate their content:
                if (($start = strpos($article->text, $match[0])) !== false) {
                    $article->text = substr_replace($article->text, $output, $start, \strlen($match[0]));
                }
            }
        }
    }

    /**
     * Loads and renders the module
     *
     * @param   string  $position  The position assigned to the module
     * @param   string  $style     The style assigned to the module
     *
     * @return  mixed
     *
     * @since   1.6
     */
    private function load($position)
    {
        $document = $this->getApplication()->getDocument();
        $renderer = $document->loadRenderer('module');
        $modules  = ModuleHelper::getModules($position);
        $params   = ['style' => 'none'];
        ob_start();

        if (!count($modules)) {
            return "";
        }

        $module = $modules[array_rand($modules)];
        echo $renderer->render($module, $params);

        return ob_get_clean();
    }
}
