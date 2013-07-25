<?php

 /**
 * @package Form Maker Lite Module
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');
defined( 'DS' )  or define('DS', DIRECTORY_SEPARATOR);

require_once (dirname(__FILE__).DS.'helper.php');
require_once JPATH_SITE.DS.'components'.DS.'com_formmaker'.DS.'recaptchalib.php';

$id=$params->get('id');
$modules	= modFormmaker::load( $id );
echo $modules;
 
// removes tags without matching module positions

?>