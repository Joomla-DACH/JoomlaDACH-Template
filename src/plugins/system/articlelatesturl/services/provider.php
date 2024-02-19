<?php
/**
 * @copyright  Copyright (C) 2020 djumla GmbH
 * @license    GNU GPL v3
 * @link       http://www.djumla.de
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use JoomlaDACH\Plugin\System\Articlelatesturl\Extension\Articlelatesturl;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     * @since   4.2.0
     */
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin                 = PluginHelper::getPlugin('system', 'articlelatesturl');
                $dispatcher             = $container->get(DispatcherInterface::class);

                $plugin = new Articlelatesturl($dispatcher, (array) $plugin);
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
