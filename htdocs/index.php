<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018
 *  Moritz von Wirth <moritz.vonwirth@phth.de>, PHTH
 *
 *  All rights reserved
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURpointOfSaleE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
require('autoload.php');
require('vendor/autoload.php');
$controller = 'ActionController';
$action = 'indexAction';
$params = $_GET;
if(array_key_exists('action', $params)) {
    $action = $params['action'].'Action';
    unset($params['action']);
}
if(array_key_exists('controller', $params)) {
    $controller = $params['controller'].'Controller';
    unset($params['controller']);
}
$controller = '\\PHTH\\ProjectEagle\\Controller\\'.$controller;
echo call_user_func_array(array(new $controller, $action), $params);
// first character groooß für $controller
// check ob Methode existiert (php fkt exist)