<?php
            ini_set('display_errors', 'Off');
            if (!defined('_JEXEC'))
                define('_JEXEC', 1);
            $DS = DIRECTORY_SEPARATOR;
            define('DS', $DS);
            preg_match("/\\{$DS}components\\{$DS}com_.*?\\{$DS}/", __FILE__, $matches, PREG_OFFSET_CAPTURE);
            $component_path = substr(__FILE__, 0, strlen($matches[0][0]) + $matches[0][1]);
            define('JPATH_COMPONENT', $component_path);
            define('JPATH_BASE', substr(__FILE__, 0, strpos(__FILE__, DS . 'components' . DS)));
            require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
            require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';
            jimport('joomla.environment.request');
            $mainframe = & JFactory::getApplication('site');
            $mainframe->initialise();
            $user = & JFactory::getUser();
            $db = & JFactory::getDBO();
            $sqlEsteModulo = "SELECT * FROM prueb_prueba";
            $db->setQuery($sqlEsteModulo);
            $resEsteModulo = $db->loadObjectList();
            if ($resEsteModulo) {
                ?>
                <table>
                    <tr>
                        <th> name </th><th> date_entered </th><th> date_modified </th><th> modified_user_id </th><th> created_by </th><th> description </th><th> assigned_user_id </th>
                    </tr>
                    <?php
                foreach ($resEsteModulo as $key => $valueEsteModulo) {
                    ?>
                    <tr>
                        <td><?php echo $valueEsteModulo->name; ?></td><td><?php echo $valueEsteModulo->date_entered; ?></td><td><?php echo $valueEsteModulo->date_modified; ?></td><td><?php echo $valueEsteModulo->modified_user_id; ?></td><td><?php echo $valueEsteModulo->created_by; ?></td><td><?php echo $valueEsteModulo->description; ?></td><td><?php echo $valueEsteModulo->assigned_user_id; ?></td>
                        
                    </tr>
                    <?php
                }
                ?>
                </table>
                <?php
            } else {
                echo "vacio";
            }
            