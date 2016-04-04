<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Prueb_prueba
 * @author     eugenio <eucm2@hotmail.com>
 * @copyright  Copyright (C) 2015. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('Prueb_pruebaFrontendHelper', JPATH_COMPONENT . '/helpers/prueb_prueba.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Prueb_prueba');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
