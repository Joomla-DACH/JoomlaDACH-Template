<?php
/**
 * @copyright  Copyright (C) 2019 djumla GmbH
 * @license    GNU GPL v3
 * @link       http://www.djumla.de
 */

defined('_JEXEC') or die('Unauthorized Access');

use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Injects the missing tag filter to category list parameters
 *
 * @since  1.0.0
 */
class PlgSystemArticleLatestURL extends CMSPlugin
{
    /**
     * @var bool auto load language
     */
    protected $autoloadLanguage = true;

    /**
     * Add additional fields to menuitem
     *
     * @param   JForm     $form  form object
     * @param   stdClass  $data  form data
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

        $input = JFactory::getApplication()->input;

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
