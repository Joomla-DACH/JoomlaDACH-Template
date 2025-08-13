<?php
/**
 * @copyright  Copyright (C) 2020 djumla GmbH
 * @license    GNU GPL v3
 * @link       http://www.djumla.de
 */

namespace JoomlaDACH\Plugin\System\Dynamicversion\Extension;

// phpcs:disable PSR1.Files.SideEffects
\defined('JPATH_PLATFORM') or die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\Application\AbstractWebApplication;
use Joomla\CMS\Cache\CacheControllerFactoryInterface;
use Joomla\CMS\Document\FactoryInterface as DocumentFactoryInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Cache\Controller\CallbackController;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\Event;
use Joomla\Event\Priority;
use Joomla\Event\SubscriberInterface;

/**
 * Dynamically insert current Joomla versions by major version
 *
 * @since  1.0.0
 */
class Dynamicversion extends CMSPlugin implements SubscriberInterface
{
    const VERSION_API = "https://downloads.joomla.org/api/v1/releases/cms/";

    /**
     * Constructor
     *
     * @param   DispatcherInterface              $dispatcher                 The object to observe
     * @param   array                            $config                     An optional associative
     *                                                                       array of configuration
     *                                                                       settings. Recognized key
     *                                                                       values include 'name',
     *                                                                       'group', 'params',
     *                                                                       'language'
     *                                                                       (this list is not meant
     *                                                                       to be comprehensive).
     * @param   DocumentFactoryInterface         $documentFactory            The application's
     *                                                                       document factory
     *
     * @since   4.2.0
     */
    public function __construct(
        DispatcherInterface $dispatcher,
        array $config,
        DocumentFactoryInterface $documentFactory
    ) {
        parent::__construct($dispatcher, $config);

        $this->documentFactory = $documentFactory;
    }

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
            'onAfterRender'  => ['onAfterRender', Priority::LOW]
        ];
    }

    /**
     * After Render Event.
     *
     * @param   Event  $event  The CMS event we are handling.
     *
     * @return  void
     *
     * @since   3.9.12
     */
    public function onAfterRender()
    {
        /** @var AbstractWebApplication $app */
        $app = $this->getApplication();

        if (!$app->isClient('site')) {
            return;
        }

        if ($app->mimeType !== 'text/html') {
            return;
        }

        $buffer = $app->getBody();

        $hasMatches = preg_match_all('/{dynamicversion (\d{0,2})\s{0,1}(\S*)}/mU', $buffer, $bodyMatches, PREG_SET_ORDER);

        if (!$hasMatches) {
            return;
        }

        foreach ($bodyMatches as $bodyMatch) {
            $major = $this->getCurrentVersion($bodyMatch[1]);

            switch ($bodyMatch[2]) {
                case "date":
                    $replacement = Factory::getDate($major['date'])->format("d.m.Y");

                    break;

                case "version":
                default:
                    $replacement = $major["version"];

                    break;
            }

            $buffer = str_replace($bodyMatch[0], $replacement, $buffer);
        }

        $app->setBody($buffer);
    }

    protected function getCurrentVersion($major)
    {
        /** @var CallbackController $cache */
        $cache = Factory::getContainer()
            ->get(CacheControllerFactoryInterface::class)
            ->createCacheController(
                'callback',
                ['defaultgroup' => 'plg_system_dynamicversion']
            );

        $cache->setCaching(true);
        $releaseInfo = $cache->get([$this, 'getReleaseInfo']);

        if (empty($releaseInfo[$major])) {
            return false;
        }

        return $releaseInfo[$major];
    }

    public function getReleaseInfo()
    {
        $httpClient = HttpFactory::getHttp();

        try {
            $response = $httpClient->get(self::VERSION_API);
        } catch (\Throwable) {
            return [];
        }

        $releases = json_decode($response->getBody(), true)['releases'];

        $majors = [];

        foreach ($releases as $release) {
            preg_match('/(\d{0,2})\./', $release['version'], $majorMatches);
            $majorVersion = $majorMatches[1];

            if (!array_key_exists($majorVersion, $majors)) {
                $majors[$majorVersion] = $release;
            }

            if (version_compare($majors[$majorVersion]['version'], $release['version'], 'gt')) {
                continue;
            }

            $majors[$majorVersion] = $release;
        }

        return $majors;
    }
}
