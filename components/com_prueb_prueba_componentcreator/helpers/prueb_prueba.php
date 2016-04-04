<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Prueb_prueba
 * @author     eugenio <eucm2@hotmail.com>
 * @copyright  Copyright (C) 2015. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class Prueb_pruebaFrontendHelper
 *
 * @since  1.6
 */
class Prueb_pruebaFrontendHelper
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_prueb_prueba/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_prueb_prueba/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Prueb_pruebaModel');
		}

		return $model;
	}
}
