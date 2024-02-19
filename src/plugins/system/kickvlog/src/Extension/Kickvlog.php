<?php
/**
 * Joomla! System plugin - KickVlog
 *
 * @author     Niels Nuebel <info@kicktemp.com>
 * @copyright  Copyright 2016 Kicktemp. All rights reserved
 * @license    GNU Public License
 * @link       http://www.kicktemp.com
 */

namespace Kicktemp\Plugin\System\Kickvlog\Extension;

// No direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\EventInterface;
use Joomla\Event\Priority;
use Joomla\Event\SubscriberInterface;

defined('_JEXEC') or die('Restricted access');

/**
 * KickVlog System Plugin
 */
class Kickvlog extends CMSPlugin implements SubscriberInterface
{
    protected $forms = array('com_content.article');

    protected $app;

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
            'onContentPrepareForm'  => ['onContentPrepareForm', Priority::LOW],
            'onAjaxYoutubeJSON'     => ['onAjaxYoutubeJSON', Priority::LOW]
        ];
    }

    /**
     * Event method that runs on content preparation
     *
     * @param   Event   $event  The current event
     * @param   Form    $form   The form object
     * @param   integer $data   The form data
     *
     * @return bool
     */
    public function onContentPrepareForm($context)
    {
        if ($context instanceof EventInterface)
        {
            /** @var Form $form */
            [$form, $data] = array_values($context->getArguments());
        }
        elseif ($context instanceof Form)
        {
            $form = $context;
        }
        else
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 0 of %1$s must be an instance of %2$s or %3$s',
                    __METHOD__,
                    EventInterface::class,
                    Form::class
                )
            );
        }

        // Load language file.
        $this->loadLanguage();

        if ($form->getName() !== 'com_content.article')
        {
            return true;
        }

        Form::addFormPath(__DIR__ . '/../../form');
        $form->loadFile('kickvlog', false);
    }

    public function onAjaxYoutubeJSON()
    {
        $app = Factory::getApplication();
        $youtube_id = $app->input->getString('youtube_id',false);
        $youtube_id = urldecode($youtube_id);
        $youtube_id = str_replace('https://youtu.be/','',$youtube_id);

        echo json_encode($this->getYoutubeData($youtube_id));
    }

    protected function getYoutubeData($youtube_id)
    {
        $vId = $youtube_id;
        $gkey = $this->params->get('youtube_api');

        $data = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=".$vId."&key=".$gkey."");

        $data = json_decode($data, true);
        $data = $data['items'][0]['snippet'];

        return $data;
    }
}
