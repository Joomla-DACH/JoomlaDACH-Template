<?php
/**
 * @copyright  Copyright (C) 2019 djumla GmbH
 * @license    GNU GPL v3
 * @link       http://www.djumla.de
 */

namespace JoomlaDACH\Plugin\System\Articlelatesturl\Extension;

// phpcs:disable PSR1.Files.SideEffects
\defined('JPATH_PLATFORM') or die;
// phpcs:enable PSR1.Files.SideEffects

defined('_JEXEC') or die('Unauthorized Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Priority;
use Joomla\Event\SubscriberInterface;

/**
 * Injects the missing tag filter to category list parameters
 *
 * @since  1.0.0
 */
class Articlelatesturl extends CMSPlugin implements SubscriberInterface
{
    /**
     * Returns an array of CMS events this plugin will listen to and the respective handlers.
     *
     * @return  array
     *
     * @since   4.2.0
     */
    public static function getSubscribedEvents(): array
    {
        /**
         * Note that onAfterRender and onAfterRespond must be the last handlers to run for this
         * plugin to operate as expected. These handlers put pages into cache. We must make sure
         * that a. the page SHOULD be cached and b. we are caching the complete page, as it's
         * output to the browser.
         */
        return [
            'onContentPrepareForm'  => ['onContentPrepareForm', Priority::LOW]
        ];
    }

    /**
     * Add additional fields to menuitem
     *
     * @param   Form     $form  form object
     * @param   \stdClass  $data  form data
     *
     * @return  boolean|void
     */
    public function onContentPrepareForm($form, $data)
    {
        if ($form->getName() !== "com_modules.module")
        {
            return;
        }
        // Pin the plugin feature to mod articles latests

        $input = Factory::getApplication()->input;

        if (
            (empty($data->module) || ($data->module !== 'mod_articles_latest' && $data->module !== 'mod_articles_category')) &&
            (empty($input->get('jform')['module']) || ($input->get('jform')['module'] !== 'mod_articles_latest' && $input->get('jform')['module'] !== 'mod_articles_category'))
        )
        {
            return;
        }

        $form->load('
            <form>
                <fields name="params">
                    <fieldset name="basic">
                        <field
                            name="urltext"
                            type="text"
                            label="Kategorie-Link Text"
                        />
                        <field
                            name="urllink"
                            type="text"
                            label="Kategorie-Link URL"
                        />
                    </fieldset>
                </fields>
            </form>'
        );

        return true;
    }
}
