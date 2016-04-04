<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Prueb_prueba
 * @author     eugenio <eucm2@hotmail.com>
 * @copyright  Copyright (C) 2015. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Pruebpruebas list controller class.
 *
 * @since  1.6
 */
class Prueb_pruebaControllerPruebpruebas extends Prueb_pruebaController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Pruebpruebas', $prefix = 'Prueb_pruebaModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
