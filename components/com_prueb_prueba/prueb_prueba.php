<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
JLoader::register('Prueb_pruebaFrontendHelper', JPATH_COMPONENT . '/helpers/prueb_prueba.php');
$controller = JControllerLegacy::getInstance('Prueb_prueba');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();