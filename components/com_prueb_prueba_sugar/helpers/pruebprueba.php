<?php
defined('_JEXEC') or die;
class Prueb_pruebaFrontendHelper{
	public static function getModel($name){
		$model = null;
		if (file_exists(JPATH_SITE . '/components/com_prueb_prueba/models/' . strtolower($name) . '.php')){
			require_once JPATH_SITE . '/components/com_prueb_prueba/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Prueb_pruebaModel');
		}
		return $model;
	}
}
                