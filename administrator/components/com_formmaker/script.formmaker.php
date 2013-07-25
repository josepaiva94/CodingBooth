<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
defined( 'DS' )  or define('DS', DIRECTORY_SEPARATOR);

class com_formmakerInstallerScript
{	
	function postflight($type, $parent)
	{
		if ($type == 'update')
		{
		
			$db =& JFactory::getDBO();
			$db->setQuery("SHOW TABLES LIKE '%".$db->getPrefix()."formmaker_sessions'");

			if (!$db->query())
			{
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			
			if($db->getNumRows()==1) 
				return false;
			
			$sqlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_formmaker'.DS.'update.mysql.sql';
			$buffer = file_get_contents($sqlfile);
			if ($buffer === false)
			{
				JError::raiseWarning(1, JText::_('JLIB_INSTALLER_ERROR_SQL_READBUFFER'));
				return false;
			}
			
			jimport('joomla.installer.helper');
			$queries = JInstallerHelper::splitSql($buffer);
			if (count($queries) == 0) {
				// No queries to process
				return 0;
			}
			
			
			// Process each query in the $queries array (split out of sql file).
			foreach ($queries as $query)
			{
				$query = trim($query);
				if ($query != '' && $query{0} != '#')
				{
					$db->setQuery($query);
					if (!$db->query())
					{
						JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
						return false;
					}
				}
			}
		
			$db->setQuery("ALTER TABLE #__formmaker ADD `paypal_mode` int(2) NOT NULL"); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `checkout_mode` varchar(20) NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `paypal_email` varchar(50) NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `payment_currency` varchar(20) NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `tax` int(11) NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `script_mail` text NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `script_mail_user` text NOT NULL "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker ADD `label_order_current` text NOT NULL "); $db->query(); 
			
			$query="SELECT * FROM #__formmaker";
			$db->setQuery($query);

			$forms=$db->loadObjectList();
			
			foreach ($forms as $form)
			{
				
				$updates="script_mail='".$db->escape($form->script1)." %all% ".$db->escape($form->script2)."'";
				$updates=$updates.", script_mail_user='".$db->escape($form->script_user1).' %all% '.$db->escape($form->script_user2)."'";
				$updates=$updates.", checkout_mode='testmode'";
				$updates=$updates.", payment_currency='USD'";
			 
				$query="UPDATE #__formmaker SET ".$updates." WHERE id = ".$form->id;
				$db->setQuery($query);
				if (!$db->query())
				{
					JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
					return false;
				} 	
			}
			
			$db->setQuery("ALTER TABLE #__formmaker DROP `script1` "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker DROP `script2` "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker DROP `script_user1` "); $db->query(); 
			$db->setQuery("ALTER TABLE #__formmaker DROP `script_user2` "); $db->query(); 
			
			
		}
	}
}