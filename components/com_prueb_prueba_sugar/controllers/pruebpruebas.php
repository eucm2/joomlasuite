<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT . '/controller.php';
class Prueb_pruebaControllerPruebpruebas extends Prueb_pruebaController{
	public function &getModel($name = 'Pruebpruebas', $prefix = 'Prueb_pruebaModel', $config = array()){
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}