<?php
require_once('include/MVC/View/views/view.list.php');

class publi_publishViewList extends ViewList {

    function ActivitiesViewList() {
        parent::ViewList();
    }

    function display() {
        ?>
        <style>
            table th{
                text-align: left;
            }
            #here{
                background-color: #3C8DBC;
                border: none;
                color: #fff;
                cursor: pointer;
                font-size: 1.1em !important;
                margin: 2px;
                padding: 5px 8px 5px 8px;
            }
        </style>
        <?php
        $db = DBManagerFactory::getInstance();
        $industry = $_POST['Industry'];
        global $current_user;
        //OBTENEMOS EL PREFIJO DE LA CONFIGURACION DE JOOMLA
        require_once '../configuration.php';
        $JConfig = new JConfig();
        $dbprefix = $JConfig->dbprefix;
        //ini_set('display_errors', 'On');
        //OBTENEMOS EL PREFIJO DE JOOMLA PRA PODER CREAR EL COMPONENTE
        $queryExisteComponente = "SELECT name FROM " . $dbprefix . "assets where name='com_$_REQUEST[fromModule]'";
        $resultExisteComponente = $db->query($queryExisteComponente);
        $rowExisteComponente = $db->fetchRow($resultExisteComponente);
        $existeComponente=false;
        //SI EL COMPONENTE NO EXISTE SE CREA

        if ($_REQUEST[exportar_joomla]) {
            $cont = 0;
            $concat_campos = "";
            foreach ($_POST['export'] as $export) {
                if ($cont == 0)
                    $concat_campos = $concat_campos . $export;
                if ($cont > 0)
                    $concat_campos = $concat_campos . "," . $export;
                $cont++;
            }
            if (!$rowExisteComponente[name]) {
                $queryInsertaAssets = "
            INSERT INTO " . $dbprefix . "assets 
            (parent_id,level,name                       ,title                      ,rules) VALUES
            ('1'      ,'1'  ,'com_$_REQUEST[fromModule]','com_$_REQUEST[fromModule]','{}');
            ";
                $resultInsertaAssets = $db->query($queryInsertaAssets);
                $manifest_cache = '{"name":"com_' . $_REQUEST[fromModule] . '","type":"component","creationDate":"2015-12-21","author":"eugenio","copyright":"Copyright (C) 2015. Todos los derechos reservados.","authorEmail":"eucm2@hotmail.com","authorUrl":"http:\/\/","version":"CVS: 1.0.0","description":"' . $_REQUEST[fromModule] . '","group":"","filename":"' . $_REQUEST[fromModule] . '"}  ';
                $queryInsertaExtensions = "
            INSERT INTO " . $dbprefix . "extensions
            (name                       ,type        ,element                    ,client_id,enabled,access,protected,manifest_cache   ,params) VALUES
            ('com_$_REQUEST[fromModule]','component ','com_$_REQUEST[fromModule]','1'      ,'1'    ,'0'   ,'0'      ,'$manifest_cache','{}');
            ";
                $resultInsertaExtensions = $db->query($queryInsertaExtensions);
                ?>
                <div class="alert alert-success">
                    <strong>Your component was successfull created</strong>
                </div>
                <?php
                $existeComponente=true;
            } else {
                ?>
                <div class="alert alert-success">
                    <strong>Your component was successfull overwrite</strong>
                </div>
                <?php
                $existeComponente=true;
            }

            $queryCamposDelModulo = "
            insert into
            campos_por_modulo (modulo,campos)
            VALUES('$_REQUEST[fromModule]', '$concat_campos')
            on duplicate key
            update  campos='$concat_campos'
            ";
            $resultCamposDelModulo = $db->query($queryCamposDelModulo);
            $controller = str_replace("_", "", $_REQUEST[fromModule]) . "s.php";
            $primera_mayuscula = ucwords($_REQUEST[fromModule]);
            $primera_mayuscula_sin_guion = str_replace("_", "", $primera_mayuscula) . "s";
            $todo_minuscula_sin_guion = str_replace("_", "", strtolower($_REQUEST[fromModule])) . "s";
            //CONTROLLER
            mkdir("../components/com_" . $_REQUEST[fromModule], 0777, true);
            $fileControllerPHP = fopen("../components/com_" . $_REQUEST[fromModule] . "/controller.php", "w");
            $txt = '<?php
defined(\'_JEXEC\') or die;
jimport(\'joomla.application.component.controller\');
class ' . $primera_mayuscula . 'Controller extends JControllerLegacy{
	public function display($cachable = false, $urlparams = false){
		require_once JPATH_COMPONENT . \'/helpers/' . $_REQUEST[fromModule] . '.php\';
		$view = JFactory::getApplication()->input->getCmd(\'view\', \'' . $todo_minuscula_sin_guion . '\');
		JFactory::getApplication()->input->set(\'view\', $view);
		parent::display($cachable, $urlparams);
		return $this;
	}
}';
            //ENTRADA
            fwrite($fileControllerPHP, $txt);
            fclose($fileControllerPHP);

            $fileEntradaPHP = fopen("../components/com_" . $_REQUEST[fromModule] . "/" . $_REQUEST[fromModule] . ".php", "w");
            $txt = '<?php
defined(\'_JEXEC\') or die;
jimport(\'joomla.application.component.controller\');
JLoader::register(\'Prueb_pruebaFrontendHelper\', JPATH_COMPONENT . \'/helpers/' . $_REQUEST[fromModule] . '.php\');
$controller = JControllerLegacy::getInstance(\'' . $primera_mayuscula . '\');
$controller->execute(JFactory::getApplication()->input->get(\'task\'));
$controller->redirect();';
            fwrite($fileEntradaPHP, $txt);
            fclose($fileEntradaPHP);
            //CONTROLLER
            mkdir("../components/com_" . $_REQUEST[fromModule] . "/controllers", 0777, true);
            $fileController = fopen("../components/com_" . $_REQUEST[fromModule] . "/controllers/" . $controller, "w");
            $txt = '<?php
defined(\'_JEXEC\') or die;
require_once JPATH_COMPONENT . \'/controller.php\';
class ' . $primera_mayuscula . 'Controller' . $primera_mayuscula_sin_guion . ' extends ' . $primera_mayuscula . 'Controller{
	public function &getModel($name = \'' . $primera_mayuscula_sin_guion . '\', $prefix = \'' . $primera_mayuscula . 'Model\', $config = array()){
		$model = parent::getModel($name, $prefix, array(\'ignore_request\' => true));
		return $model;
	}
}';
            fwrite($fileController, $txt);
            fclose($fileController);
            //H E L P E R
            //CREAMOS LA CARPETA DENTRO DEL com_componente/helpers
            mkdir("../components/com_" . $_REQUEST[fromModule] . "/helpers", 0777, true);
            //CREAMOS EL NOMBRE DEL ARCHIVO HELPER
            $nombreHelpers = $_REQUEST[fromModule] . ".php";
            //CREAMOS EL ARCHIVO HELPER CON EL NOMBRE DEL MODULO DE SUGAR
            $fileHelper = fopen("../components/com_" . $_REQUEST[fromModule] . "/helpers/" . $nombreHelpers, "w");
            $txt = '<?php
defined(\'_JEXEC\') or die;
class ' . $primera_mayuscula . 'FrontendHelper{
	public static function getModel($name){
		$model = null;
		if (file_exists(JPATH_SITE . \'/components/com_' . $_REQUEST[fromModule] . '/models/\' . strtolower($name) . \'.php\')){
			require_once JPATH_SITE . \'/components/com_' . $_REQUEST[fromModule] . '/models/\' . strtolower($name) . \'.php\';
			$model = JModelLegacy::getInstance($name, \'' . $primera_mayuscula . 'Model\');
		}
		return $model;
	}
}
                ';
            fwrite($fileHelper, $txt);
            fclose($fileHelper);
            //V I E W
            //CREAMOS LA CARPETA DENTRO DEL com_componente/views
            mkdir("../components/com_" . $_REQUEST[fromModule] . "/views", 0777, true);
            mkdir("../components/com_" . $_REQUEST[fromModule] . "/views/" . $todo_minuscula_sin_guion, 0777, true);
            //CREAMOS EL ARCHIVO HELPER CON EL NOMBRE DEL MODULO DE SUGAR
            $fileHelper = fopen("../components/com_" . $_REQUEST[fromModule] . "/views/" . $todo_minuscula_sin_guion . "/view.html.php", "w");
            $txt = '<?php
defined(\'_JEXEC\') or die;
jimport(\'joomla.application.component.view\');
class ' . $primera_mayuscula . 'View' . $primera_mayuscula_sin_guion . ' extends JViewLegacy{
	protected $items;
	protected $pagination;
	protected $state;
	protected $params;
	public function display($tpl = null){
		$app = JFactory::getApplication();
		$this->state      = $this->get(\'State\');
		$this->params     = $app->getParams(\'com_' . $_REQUEST[fromModule] . '\');
		if (count($errors = $this->get(\'Errors\'))){
			throw new Exception(implode("\n", $errors));
		}
		$this->_prepareDocument();
		parent::display($tpl);
	}
	protected function _prepareDocument(){
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;
		$menu = $menus->getActive();
		if ($menu){
			$this->params->def(\'page_heading\', $this->params->get(\'page_title\', $menu->title));
		}
		else{
			$this->params->def(\'page_heading\', JText::_(\'COM_' . strtoupper($_REQUEST[fromModule]) . '_DEFAULT_PAGE_TITLE\'));
		}
		$title = $this->params->get(\'page_title\', \'\');
		if (empty($title)){
			$title = $app->get(\'sitename\');
		}
		elseif ($app->get(\'sitename_pagetitles\', 0) == 1){
			$title = JText::sprintf(\'JPAGETITLE\', $app->get(\'sitename\'), $title);
		}
		elseif ($app->get(\'sitename_pagetitles\', 0) == 2){
			$title = JText::sprintf(\'JPAGETITLE\', $title, $app->get(\'sitename\'));
		}
		$this->document->setTitle($title);
		if ($this->params->get(\'menu-meta_description\')){
			$this->document->setDescription($this->params->get(\'menu-meta_description\'));
		}
		if ($this->params->get(\'menu-meta_keywords\')){
			$this->document->setMetadata(\'keywords\', $this->params->get(\'menu-meta_keywords\'));
		}
		if ($this->params->get(\'robots\')){
			$this->document->setMetadata(\'robots\', $this->params->get(\'robots\'));
		}
	}
	public function getState($state){
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}
}
                ';


            $cabecera = "";
            foreach ($_POST["export"] as $export) {
                $cabecera = $cabecera . "<th> $export </th>";
            }

            foreach ($_POST["export"] as $export) {
                $cuerpo = $cuerpo . '<td><?php echo $valueEsteModulo->' . $export . '; ?></td>';
            }



            fwrite($fileHelper, $txt);
            fclose($fileHelper);
            //T M P L
            mkdir("../components/com_" . $_REQUEST[fromModule] . "/views/" . $todo_minuscula_sin_guion . "/tmpl", 0777, true);
            $fileDefault = fopen("../components/com_" . $_REQUEST[fromModule] . "/views/" . $todo_minuscula_sin_guion . "/tmpl/default.php", "w");
            $txt = '<?php
ini_set(\'display_errors\', \'Off\');
if (!defined(\'_JEXEC\'))
    define(\'_JEXEC\', 1);
$DS = DIRECTORY_SEPARATOR;
define(\'DS\', $DS);
preg_match("/\\\{$DS}components\\\\{$DS}com_.*?\\\{$DS}/", __FILE__, $matches, PREG_OFFSET_CAPTURE);
$component_path = substr(__FILE__, 0, strlen($matches[0][0]) + $matches[0][1]);
define(\'JPATH_COMPONENT\', $component_path);
define(\'JPATH_BASE\', substr(__FILE__, 0, strpos(__FILE__, DS . \'components\' . DS)));
require_once ( JPATH_BASE . DS . \'includes\' . DS . \'defines.php\' );
require_once JPATH_BASE . DS . \'includes\' . DS . \'framework.php\';
jimport(\'joomla.environment.request\');
$mainframe = & JFactory::getApplication(\'site\');
$mainframe->initialise();
$user = & JFactory::getUser();
$db = & JFactory::getDBO();
$sqlEsteModulo = "SELECT * FROM ' . $_REQUEST[fromModule] . '";
$db->setQuery($sqlEsteModulo);
$resEsteModulo = $db->loadObjectList();
if ($resEsteModulo) {
    ?>
    <table>
        <tr>
            ' . $cabecera . '
        </tr>
    <?php
    foreach ($resEsteModulo as $key => $valueEsteModulo) {
    ?>
        <tr>
            ' . $cuerpo . '
        </tr>
    <?php
    }
    ?>
    </table>
    <?php
} else {
    echo "vacio";
}
';
            fwrite($fileDefault, $txt);
            fclose($fileDefault);


            $fileDefaultXml = fopen("../components/com_" . $_REQUEST[fromModule] . "/views/" . $todo_minuscula_sin_guion . "/tmpl/default.xml", "w");
            $txt = '<?xml version="1.0" encoding="utf-8"?>
<metadata>
	<layout title="' . $_REQUEST[fromModule] . '" option="View">
        <message>
                        <![CDATA[' . $_REQUEST[fromModule] . ']]>
        </message>
	</layout>
</metadata>
            ';
            fwrite($fileDefaultXml, $txt);
            fclose($fileDefaultXml);
        }


        $queryColumnas = " SHOW COLUMNS FROM " . $_REQUEST[fromModule] . " -- Field,Type,Null,Key,Default,Extra";
        //echo $queryColumnas;
        $resultColumnas = $db->query($queryColumnas);
        ?>
        <form action="index.php?module=<?php echo $_REQUEST[module]; ?>&action=<?php echo $_REQUEST[action]; ?>&fromModule=<?php echo $_REQUEST[fromModule]; ?>&fromAction=<?php echo $_REQUEST[fromAction]; ?>" method="post">
            <input type="hidden" name="parentTab" value="<?php echo $_REQUEST[parentTab]; ?>"/>
        <!--            <input type="hidden" name="fromModule" value="<?php echo $_REQUEST[fromModule]; ?>"/>-->
        <!--            <input type="hidden" name="fromAction" value="<?php echo $_REQUEST[fromAction]; ?>"/>-->
            <div class="search_form">
                <div class="view">
                    <div>
                        Select de fields do you want publish on joomla component
                    </div>
                    <?php
                    if ($existeComponente) {
                        ?>
                        <div>
                            your component will be in folder <strong>com_<?php echo $_REQUEST[fromModule]; ?></strong> and in the table <strong><?php echo $_REQUEST[fromModule]; ?></strong>
                        </div>
                        <div>
                            You can see your component <a href="../index.php?option=com_<?php echo $_REQUEST[fromModule]; ?>&view=<?php echo $todo_minuscula_sin_guion; ?>" target="_blank" id="here">Here</a>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    //SI NO SE A CREADO EL COMPONENTE EL BOTON SE LLAMA "Create component on joomla"
                    if (!$existeComponente) {
                        ?>
                        <input type="submit" name="exportar_joomla" value="Create component on joomla"/>
                        <?php
                    } else {
                        ?>
                        <input type="submit" name="exportar_joomla" value="Overwrite component on joomla"/>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <?php
            //ini_set('display_errors', 'On');
            $queryCamposDelModulo = "select modulo,campos from campos_por_modulo where modulo='$_REQUEST[fromModule]'";
            //echo $queryCamposDelModulo;
            $resultCamposDelModulo = $db->query($queryCamposDelModulo);
            $rowCamposDelModulo = $db->fetchRow($resultCamposDelModulo);
            $lista_campos = explode(",", $rowCamposDelModulo[campos]);
            if ($resultColumnas->num_rows > 0) {
                ?>
                <table cellpadding="0" cellspacing="0" width="100%" border="0" class="table footable-loaded footable default">
                    <thead>
                        <tr>
                            <th align="left" >
                                Field
                            </th>
                            <th align="left" >
                                Type
                            </th>
                            <th align="left">
                                Default
                            </th>
                            <th align="left">
                                Export
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowColumnas = $db->fetchRow($resultColumnas)) {
                            ?>
                            <tr  class="oddListRowS1">
                                <td>
                                    <?php echo $rowColumnas[Field]; ?>
                                </td>
                                <td>
                                    <?php echo $rowColumnas[Type]; ?>
                                </td>
                                <td>
                                    <?php echo $rowColumnas["Default"]; ?>
                                </td>
                                <td>
                                    <input type="checkbox" name="export[]" id="export_<?php echo $rowColumnas[Field]; ?>" <?php if ($rowColumnas[Key] == "PRI") echo " disabled='disabled' " ?> 
                                           class="export" value="<?php echo $rowColumnas[Field]; ?>" <?php if (in_array($rowColumnas[Field], $lista_campos)) echo ' checked="checked" '; ?>  />
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            <?php
        }
    }

}

