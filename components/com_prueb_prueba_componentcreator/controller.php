<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Prueb_prueba
 * @author     eugenio <eucm2@hotmail.com>
 * @copyright  Copyright (C) 2015. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Class Prueb_pruebaController
 *
 * @since  1.6
 */
class Prueb_pruebaController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/prueb_prueba.php';

		$view = JFactory::getApplication()->input->getCmd('view', 'pruebpruebas');
		JFactory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
