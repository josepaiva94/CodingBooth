<?php 
  
 /**
 * @package Form Maker
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

	function cancel_secondary()
	{
		JToolBarHelper :: custom( 'cancel_secondary', 'cancel.png', '', 'Cancel', '', '' );
	}

//////////////////////////////////////////////////	
	function edit_submit_text()
	{
		JToolBarHelper :: custom( 'edit_my_submit_text', 'edit.png', '', 'Actions after submission', '', '' );
	}
	
	function remove_submit()
	{
		JToolBarHelper :: custom( 'remove_submit', 'delete.png', '', 'Delete', '', '' );
	}

	function edit_submit()
	{
		JToolBarHelper :: custom( 'edit_submit', 'edit.png', '', 'Edit', '', '' );
	}
	
	function undo()
	{
		JToolBarHelper :: custom( 'undo', 'back.png', '', 'Undo', '', '' );
	}
	
	function redo()
	{
		JToolBarHelper :: custom( 'redo', 'forward.png', '', 'Redo', '', '' );
	}
	
///////////////////////////////////
	

	

class TOOLBAR_formmaker {

	function _THEMES() {
		$document =& JFactory::getDocument();
		$document->addStyleSheet('components/com_formmaker/FormMakerLogo.css');
		JToolBarHelper::title( 'Form Maker: Themes');		
		JToolBarHelper::addNew('add_themes');
		JToolBarHelper::editList('edit_themes');
		JToolBarHelper::makeDefault();
		JToolBarHelper::deleteList('Are you sure you want to delete? ', 'remove_themes');

	}

	function _NEW_Form_options() 
	{		
		JToolBarHelper::title( 'Form Maker: Form Options');		
		JToolBarHelper::save('save_form_options');
		JToolBarHelper::apply('apply_form_options');
		cancel_secondary();
	}

	
	function _NEW_THEMES() {
		JToolBarHelper::title( 'Form Maker: Add Theme');		
		JToolBarHelper::apply('apply_themes');
		JToolBarHelper::save('save_themes');
		JToolBarHelper::cancel('cancel_themes');		
	}
	
	function EDIT_SUBMITS()
	{
		JToolBarHelper::title( 'Form Maker: Edit Submission');		
		JToolBarHelper::apply('apply_submit');
		JToolBarHelper::save('save_submit');
		JToolBarHelper::cancel('cancel_submit');		
	}
	
	function _SUBMITS() {
		$document =& JFactory::getDocument();
		$document->addStyleSheet('components/com_formmaker/FormMakerLogo.css');
		JToolBarHelper::title( 'Form Maker: Submissions' );
		remove_submit();
		JToolBarHelper::editList('edit_submit');
	}

	function _NEW() {
		JToolBarHelper::title( 'Form Maker: Add New Form');		
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper :: custom( 'save_and_new', 'save.png', '', 'Save & New', '', '' );
		JToolBarHelper :: custom( 'save_as_copy', 'copy.png', '', 'Save as Copy', '', '' );
		JToolBarHelper :: custom( 'form_options_temp', 'checkin.png', '', 'Form Options', '', '' );	
		JToolBarHelper::cancel();		
	}

	function _DEFAULT() {
		//$document =& JFactory::getDocument();
		//$document->addStyleSheet('components/com_formmaker/FormMakerLogo.css');
		JToolBarHelper::title( 'Form Maker');		
		JToolBarHelper::addNew();
		JToolBarHelper::editList();
		JToolBarHelper::custom( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
		JToolBarHelper::deleteList();

	}

}

?>