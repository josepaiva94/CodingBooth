<?php 
  
 /**
 * @package Form Maker
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');


class FormmakerController extends JControllerLegacy
{


	function element()
	{
		$model	= &$this->getModel( 'element' );
		$view	= &$this->getView( 'element');
		$view->setModel( $model, true );
		$view->display();
	}

	function select_article()
	{
		$model	= &$this->getModel( 'select_article' );
		$view	= &$this->getView( 'select_article');
		$view->setModel( $model, true );
		$view->display();
	}

}

?>