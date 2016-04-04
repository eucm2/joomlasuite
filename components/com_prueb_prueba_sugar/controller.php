<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
class Prueb_pruebaController extends JControllerLegacy{
	public function display($cachable = false, $urlparams = false){
		require_once JPATH_COMPONENT . '/helpers/prueb_prueba.php';
		$view = JFactory::getApplication()->input->getCmd('view', 'pruebpruebas');
		JFactory::getApplication()->input->set('view', $view);
		parent::display($cachable, $urlparams);
		return $this;
	}
}