<?php

/**
 * @version    CVS: 1.0.0
 * @package    Mod_HomepageHero
 * @author     djumla GmbH, Lukas Jardin <info@djumla.de>
 * @copyright  2019 djumla GmbH
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
$document = Factory::getDocument();

$moduleclass_sfx  = htmlspecialchars($params->get('class_sfx', ''), ENT_COMPAT, 'UTF-8');
require JModuleHelper::getLayoutPath('mod_imagetext', $params->get('layout', 'default'));
