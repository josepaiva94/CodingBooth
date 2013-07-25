<?php 
  
 /**
 * @package Form Maker
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT . '/admin.formmaker.html.php';
require_once JPATH_COMPONENT . '/toolbar.formmaker.html.php';
require_once JPATH_COMPONENT . '/controller.php' ;

JTable::addIncludePath( JPATH_COMPONENT.'/tables' );


$controller = new FormmakerController();


$task	= JRequest::getCmd('task'); 

$id = JRequest::getVar('id', 0, 'get', 'int');

$bar=& JToolBar::getInstance( 'toolbar' );
$bar->appendButton('Custom','<a href="http://web-dorado.com/products/joomla-form.html" target="_blank" style=""><img src="components/com_formmaker/images/buyme.png" border="0" alt="http://web-dorado.com/files/fromSpiderCatalogJoomla.php" style="float:left"></a>', 'custom');


// checks the $task variable and 
// choose an appropiate function


switch ( $task )

{

	case 'themes'  :
	{
		TOOLBAR_formmaker::_THEMES();
	}
		break;
		
	case 'add_themes'  :
	case 'edit_themes'  :
	{
		TOOLBAR_formmaker::_NEW_THEMES();
	}
		break;
		
	case 'submits'  :
	{
		TOOLBAR_formmaker::_SUBMITS();
	}
		break;
		
	case 'edit_submit'  :
	{
		TOOLBAR_formmaker::EDIT_SUBMITS();
	}
		break;
		
	case 'add'  :
	case 'edit'  :	
	{
		TOOLBAR_formmaker::_NEW();
	}
		break;

	case 'form_options'  :
	case 'form_options_temp'  :
	{
	TOOLBAR_formmaker::_NEW_Form_options();
	}
	break;



	default:
		TOOLBAR_formmaker::_DEFAULT();
		break;

}



switch($task){

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	case 'paypal_info':
		paypal_info();
		break;
		
	case 'default':
		setdefault();
		break;
		
	case 'product_option':
		product_option();
		break;
			
	case 'preview':
		preview_formmaker();
		break;
		
	case 'themes':
		show_themes();
		break;
		
	case 'add_themes':
		add_themes();
		break;
		
	case 'edit_themes':
		edit_themes();
		break;
		
	case 'apply_themes':	
	case 'save_themes':		
		save_themes($task);
		break;
		
	case 'remove_themes':
		remove_themes();
		break;
		
	case 'cancel_themes':
		cancel_themes();
		break;
		
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	case 'forms':
		show();
		
		break;
		
	case 'submits':
		show_submits();
		
		break;

	case 'element':

		$controller->execute( $task );

		$controller->redirect();

		break;

	/*case 'select_article':

		$controller->execute( $task );

		$controller->redirect();

		break;*/

	case 'select_article':

		select_article();
		break;

	case 'add':

		add();

		break;

	case 'cancel':		

		cancel();

		break;

	case 'apply':	
	case 'save_and_new':	
	case 'save':		

		save($task);

		break;

	case 'edit':

    		edit();

    		break;
			
	case 'save_as_copy':

    		save_as_copy();
    		break;
			
	case 'copy':

    		copy_form();
    		break;
			
	case 'form_options':
			form_options();
			break;
		
	case 'form_options_temp':
    		form_options_temp();
    		break;
			
			
//////////////////////////////////////////////////////////////////		
	case 'apply_form_options':
	case 'save_form_options':
    		save_form_options($task);
    		break;

//////////////////////////////////////////////////////////////////		
	case 'cancel_secondary':
    		cancelSecondary();
    		break;
		

//////////////////////////////////////////////////////////////////		
	case 'remove':

		remove();

		break;

		
	case 'remove_submit':
		removeSubmit();
		break;
		
	case 'edit_submit':
		editSubmit();
		break;

	case 'save_submit':
	case 'apply_submit':
		saveSubmit($task);
		break;

	case 'cancel_submit':
		cancelSubmit();
		break;

 	 case 'publish':
   		change(1 );
    		break;

	 case 'unpublish':
	   	change(0 );
	    	break;				

	 case 'gotoedit':
	   	gotoedit();
	    	break;	

	case 'country_list':
	   	country_list();
	    	break;
			
	 case 'show_map':
	   	show_map();
	    	break;

	default:
		showredirect();
		break;



}

function form_options(){

	$db		=& JFactory::getDBO();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));

	$id 	= $cid[0];
	$row =& JTable::getInstance('formmaker', 'Table');

	// load the row from the db table
	$row->load( $id);

	
	$query = "SELECT * FROM #__formmaker_themes ORDER BY title";
	$db->setQuery( $query);
	$themes = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}



	// display function 
	HTML_contact::form_options($row, $themes);
}


function paypal_info(){
	$id 	= JRequest::getVar('id');
    $db =& JFactory::getDBO();
	$query = "SELECT * FROM #__formmaker_sessions where group_id=".$id;
	$db->setQuery( $query);
	$row = $db->loadObject();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
//print_r($row);
	HTML_contact::paypal_info($row);

//return;

}

function show_map(){

	$long 	= JRequest::getVar('long');
	$lat 	= JRequest::getVar('lat');

	HTML_contact::show_map($long,$lat);

}

function country_list(){

	$id 	= JRequest::getVar('field_id');

	HTML_contact::country_list($id);

}

function product_option(){

	$id 	= JRequest::getVar('field_id');
	$property_id= JRequest::getVar('property_id');
	HTML_contact::product_option($id,$property_id);

}


//////////////////////////////////////////////////////////////
function gotoedit(){
	$mainframe = &JFactory::getApplication();

	$id 	= JRequest::getVar('id');

	$msg ="The form was saved successfully.";
	$link ='index.php?option=com_formmaker&task=edit&cid[]='.$id;

	$mainframe->redirect($link, $msg);

}

function showredirect(){
	$mainframe = &JFactory::getApplication();

	$link = 'index.php?option=com_formmaker&task=forms';

	$mainframe->redirect($link);

}

function add(){


    $db =& JFactory::getDBO();
	$query = "SELECT * FROM #__formmaker_themes ORDER BY title";
	$db->setQuery( $query);
	$themes = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
// display function

	HTML_contact::add($themes);
}

function show_submits(){

	$mainframe = &JFactory::getApplication();
    $db =& JFactory::getDBO();
	$query = "SELECT id, title FROM #__formmaker order by title";
	$db->setQuery( $query);
	$forms = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
//	$form_id = JRequest::getVar('form_id');

	$option='com_formmaker';
	$task	= JRequest::getCmd('task'); 
	$form_id= $mainframe-> getUserStateFromRequest( $option.'form_id', 'form_id','id','cmd' );
	
	if($form_id){
	
	$query = "SELECT id FROM #__formmaker where id=".$form_id;
	$db->setQuery( $query);
	$exists = $db->LoadResult();
	
	if(!$exists)
		$form_id=0;
	}
	
	$filter_order= $mainframe-> getUserStateFromRequest( $option.'filter_order2', 'filter_order2','id','cmd' );
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.'filter_order_Dir2', 'filter_order_Dir2','','word' );
	$search_submits = $mainframe-> getUserStateFromRequest( $option.'search_submits', 'search_submits','','string' );
	$search_submits = JString::strtolower( $search_submits );
	
	$ip_search = $mainframe-> getUserStateFromRequest( $option.'ip_search', 'ip_search','','string' );
	$ip_search = JString::strtolower( $ip_search );
	
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();
	$lists['startdate']= JRequest::getVar('startdate', "");
	$lists['enddate']= JRequest::getVar('enddate', "");
	$lists['hide_label_list']= JRequest::getVar('hide_label_list', "");
	
	if ( $search_submits ) {
		$where[] = 'element_label LIKE "%'.$db->escape($search_submits).'%"';
	}	
	
	if ( $ip_search ) {
		$where[] = 'ip LIKE "%'.$db->escape($ip_search).'%"';
	}	
	
	if($lists['startdate']!='')
		$where[] ="  `date`>='".$lists['startdate']." 00:00:00' ";
	if($lists['enddate']!='')
		$where[] ="  `date`<='".$lists['enddate']." 23:59:59' ";
	
	if ($form_id=='')
		if($forms)
		$form_id=$forms[0]->id;
	
	$where[] = 'form_id="'.$form_id.'"';

	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

	$orderby 	= ' ';
	if ($filter_order == 'id' or $filter_order == 'title' or $filter_order == 'mail')
	{
		$orderby 	= ' ORDER BY `date` desc';
	} 
	else 
		if(!strpos($filter_order,"_field")) 
		{
			$orderby 	= ' ORDER BY '.$filter_order .' '. $filter_order_Dir .'';
		}	
	
	$query = "SELECT * FROM #__formmaker_submits". $where;
	$db->setQuery( $query);
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){echo $db->stderr();return false;}
	
	$where_labels=array();
	$n=count($rows);
	$labels= array();
	for($i=0; $i < $n ; $i++)
	{
		$row = &$rows[$i];
		if(!in_array($row->element_label, $labels))
		{
			array_push($labels, $row->element_label);
		}
	}
	
	$query = "SELECT id FROM #__formmaker_submits WHERE form_id=".$form_id." and element_label=0";
	$db->setQuery( $query);
	$ispaypal = $db->loadResult();
	if($db->getErrorNum()){echo $db->stderr();return false;}
	
	$sorted_labels_type= array();
	$sorted_labels_id= array();
	$sorted_labels= array();
	$label_titles=array();
	if($labels)
	{
		
		$label_id= array();
		$label_order= array();
		$label_order_original= array();
		$label_type= array();
		
		$this_form =& JTable::getInstance('formmaker', 'Table');
		$this_form->load( $form_id);
		
		if(strpos($this_form->label_order, 'type_paypal_'))
		{
			$this_form->label_order=$this_form->label_order."item_total#**id**#Item Total#**label**#type_paypal_payment_total#****#total#**id**#Total#**label**#type_paypal_payment_total#****#0#**id**#Payment Status#**label**#type_paypal_payment_status#****#";
		}
	
		$label_all	= explode('#****#',$this_form->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_order_each=explode('#**label**#', $label_id_each[1]);
			
			array_push($label_order_original, $label_order_each[0]);
			
			$ptn = "/[^a-zA-Z0-9_]/";
			$rpltxt = "";
			$label_temp=preg_replace($ptn, $rpltxt, $label_order_each[0]);
			array_push($label_order, $label_temp);
			
			array_push($label_type, $label_order_each[1]);
		}
		
		foreach($label_id as $key => $label) 
			if(in_array($label, $labels))
			{
				array_push($sorted_labels_type, $label_type[$key]);
				array_push($sorted_labels, $label_order[$key]);
				array_push($sorted_labels_id, $label);
				array_push($label_titles, $label_order_original[$key]);
				$search_temp = $mainframe-> getUserStateFromRequest( $option.$form_id.'_'.$label.'_search', $form_id.'_'.$label.'_search','','string' );
				$search_temp = JString::strtolower( $search_temp );
				$lists[$form_id.'_'.$label.'_search']	 = $search_temp;
				
				if ( $search_temp ) {
					$where_labels[] = '(group_id in (SELECT group_id FROM #__formmaker_submits WHERE element_label='.$label.' AND element_value LIKE "%'.$db->escape($search_temp).'%"))';
				}	

			}
	}
	
	$where_labels 		= ( count( $where_labels ) ? ' ' . implode( ' AND ', $where_labels ) : '' );
	if($where_labels)
		$where=  $where.' AND '.$where_labels;

	$rows_ord = array();
	if(strpos($filter_order,"_field"))
	{
		
		$query = "insert into #__formmaker_submits (form_id,	element_label, element_value, group_id,`date`,ip) select $form_id,'".str_replace("_field","",$filter_order)."', '', group_id,`date`,ip from  #__formmaker_submits where `form_id`=$form_id and group_id not in (select group_id from #__formmaker_submits where `form_id`=$form_id and element_label='".str_replace("_field","",$filter_order)."' group by  group_id) group by group_id";
	
		$db->setQuery( $query);
		$db->query();
		if($db->getErrorNum()){	echo $db->stderr();	return false;}
		
		$query = "SELECT group_id, date, ip FROM #__formmaker_submits ". $where." and element_label='".str_replace("_field","",$filter_order)."' order by element_value ".$filter_order_Dir;
		//echo $query;
		$db->setQuery( $query);
		$rows_ord = $db->loadObjectList();
		if($db->getErrorNum()){	echo $db->stderr();	return false;}
	
	}

	$query = 'SELECT group_id, date, ip FROM #__formmaker_submits'. $where.' group by group_id'. $orderby;
	$db->setQuery( $query );
	$group_ids=$db->loadObjectList();
	$total = count($group_ids);
	
	
	$query = 'SELECT count(distinct group_id) FROM #__formmaker_submits where form_id ="'.$form_id.'"';
	$db->setQuery( $query );
	$total_entries=$db->LoadResult();
	
	if(count($rows_ord)!=0){
	$group_ids=$rows_ord;
	$total = count($rows_ord);
	
	$query = "SELECT group_id, date, ip FROM #__formmaker_submits ". $where." and element_label='".str_replace("_field","",$filter_order)."' order by element_value ".$filter_order_Dir." limit $limitstart, $limit ";
	$db->setQuery( $query);
	$rows_ord = $db->loadObjectList();

	if($db->getErrorNum()){

		echo $db->stderr();

		return false;

	}
	
	
	
	
	
	}
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	
	
	
	
	$where2 = array();
	
	for($i=$pageNav->limitstart; $i<$pageNav->limitstart+$pageNav->limit; $i++)
	{
		if($i<$total)
$where2 [] ="group_id='".$group_ids[$i]->group_id."'";
 
	}
	$where2 = ( count( $where2 ) ? ' AND ( ' . implode( ' OR ', $where2 ).' )' : '' );
	$where3=$where;
	$where=$where.$where2;
	$query = "SELECT * FROM #__formmaker_submits ". $where.$orderby.'';
	$db->setQuery( $query);
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){

		echo $db->stderr();

		return false;

	
	}
	
	$query = 'SELECT views FROM #__formmaker_views WHERE form_id="'.$form_id.'"'	;
	$db->setQuery( $query );
	$total_views = $db->loadResult();	
	

	$lists['order_Dir']	= $filter_order_Dir;

	$lists['order']		= $filter_order;	



	// search filter	

$lists['search_submits']= $search_submits;	
$lists['ip_search']=$ip_search;

	if(count($rows_ord)==0)
		$rows_ord=$rows;
    // display function
	
	$query = "SELECT * FROM #__formmaker_sessions ". $where.'';
	$db->setQuery( $query);
	$rows_paypal = $db->loadObjectList();
	if($db->getErrorNum()){		echo $db->stderr();		return false;		}

	HTML_contact::show_submits($rows, $forms, $lists, $pageNav, $sorted_labels, $label_titles, $rows_ord, $filter_order_Dir,$form_id, $sorted_labels_id, $sorted_labels_type, $total_entries, $total_views,$where,$rows_paypal, $where3);

}

function show(){



	$mainframe = JFactory::getApplication();
	$aaa = JModelList::getUserStateFromRequest('filter_order', 'filter_order');

	
    $db =& JFactory::getDBO();
	$option='com_formmaker';
	$filter_order= $mainframe-> getUserStateFromRequest( $option.'filter_order', 'filter_order','id','cmd' );
	

	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$search = $mainframe-> getUserStateFromRequest( $option.'search', 'search','','string' );
	
	
	$search = JString::strtolower( $search );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();
	if ( $search ) {

		$where[] = 'title LIKE "%'.$db->escape($search).'%"';

	}	


	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

	if ($filter_order == 'id' or $filter_order == 'group_id' or $filter_order == 'date' or $filter_order == 'ip'){

		$orderby 	= ' ORDER BY id';

	} else {

		$orderby 	= ' ORDER BY '. 

         $filter_order .' '. $filter_order_Dir .', id';

	}	

	

	// get the total number of records

	$query = 'SELECT COUNT(*)'

	. ' FROM #__formmaker'

	. $where

	;
	$db->setQuery( $query );

	$total = $db->loadResult();



	jimport('joomla.html.pagination');

	$pageNav = new JPagination( $total, $limitstart, $limit );	

	$query = "SELECT * FROM #__formmaker". $where. $orderby;

	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );

	$rows = $db->loadObjectList();

	if($db->getErrorNum()){

		echo $db->stderr();

		return false;

	}



	// table ordering

	$lists['order_Dir']	= $filter_order_Dir;

	$lists['order']		= $filter_order;	



	// search filter	

        $lists['search']= $search;	

	

    // display function

	HTML_contact::show($rows, $pageNav, $lists);

}

function show_themes(){

	$mainframe = &JFactory::getApplication();
	$option='com_formmaker';
	
    $db =& JFactory::getDBO();
	
	$filter_order= $mainframe-> getUserStateFromRequest( $option.'filter_order_themes', 'filter_order_themes','id','cmd' );
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.'filter_order_Dir_themes', 'filter_order_Dir_themes','desc','word' );
	$filter_state = $mainframe-> getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$search_theme = $mainframe-> getUserStateFromRequest( $option.'search_theme', 'search_theme','','string' );
	$search_theme = JString::strtolower( $search_theme );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	$where = array();

	if ( $search_theme ) {
		$where[] = '#__formmaker_themes.title LIKE "%'.$db->escape($search_theme).'%"';
	}	
	
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id '.$filter_order_Dir;
	} else {
		$orderby 	= ' ORDER BY '. 
         $filter_order .' '. $filter_order_Dir .', id';
	}	
	
	// get the total number of records
	$query = 'SELECT COUNT(*)'. ' FROM #__formmaker_themes'. $where;
	$db->setQuery( $query );
	$total = $db->loadResult();

	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	
	
	$query = "SELECT * FROM #__formmaker_themes". $where. $orderby;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){		echo $db->stderr();		return false;	}

	// table ordering

	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;	

	// search filter	
        $lists['search_theme']= $search_theme;	

    // display function

	HTML_contact::show_themes($rows, $pageNav, $lists);

}

function preview_formmaker()
{
	$getparams=JRequest::get('get');
	
    $db =& JFactory::getDBO();
	
	$query = "SELECT css FROM #__formmaker_themes WHERE id=".$getparams['theme'];
	$db->setQuery( $query);
	$css = $db->loadResult();
	if($db->getErrorNum()){		echo $db->stderr();		return false;	}

	HTML_contact::preview_formmaker($css);
}

function setdefault()
{
	$mainframe = &JFactory::getApplication();
	$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
	JArrayHelper::toInteger($cid);
	
	if (isset($cid[0]) && $cid[0]) 
		$id = $cid[0];
	else 
	{
		$mainframe->redirect(  'index.php?option=com_formmaker&task=themes',JText::_('No Items Selected') );
		return false;
	}
	
	$db =& JFactory::getDBO();

	// Clear home field for all other items
	$query = 'UPDATE #__formmaker_themes SET `default` = 0 WHERE 1';
	$db->setQuery( $query );
	if ( !$db->query() ) {
		$msg =$db->getErrorMsg();
		echo $msg;
		return false;
	}

	// Set the given item to home
	$query = 'UPDATE #__formmaker_themes SET `default` = 1 WHERE id = '.(int) $id;
	$db->setQuery( $query );
	if ( !$db->query() ) {
		$msg = $db->getErrorMsg();
		return false;
	}
		
	$msg = JText::_( 'Default Theme Seted' );
	$mainframe->redirect( 'index.php?option=com_formmaker&task=themes' ,$msg);
}

function add_themes(){

	//$lists['published'] = JHTML::_('select.booleanlist', 'published' , 'class="inputbox"', 1);
		
	$db		=& JFactory::getDBO();
	$query = "SELECT * FROM #__formmaker_themes where `default`=1";
	$db->setQuery($query);
	$def_theme = $db->loadObject();
// display function
		
	HTML_contact::add_themes($def_theme);
}

function edit_themes(){
	$db		=& JFactory::getDBO();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));

	$id 	= $cid[0];
	$row =& JTable::getInstance('formmaker_themes', 'Table');
	// load the row from the db table
	$row->load( $id);
	
	// display function 
	HTML_contact::edit_themes( $row);
}

function remove_themes(){
	$mainframe = &JFactory::getApplication();
  // Initialize variables	
  $db =& JFactory::getDBO();
  // Define cid array variable
  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
  // Make sure cid array variable content integer format
  JArrayHelper::toInteger($cid);
  $query = 'SELECT id FROM #__formmaker_themes WHERE `default`=1 LIMIT 1';
  $db->setQuery( $query );
  $def = $db->loadResult();
  if($db->getErrorNum()){
	  echo $db->stderr();
	  return false;
  }
  $msg='';
  $k=array_search($def, $cid);
  if ($k>0)
  {
	  $cid[$k]=0;
	  $msg="You can't delete default theme";
  }
  
  if ($cid[0]==$def)
  {
	  $cid[0]=0;
	  $msg="You can't delete default theme";
  }
  
  // If any item selected
  if (count( $cid )) {
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    $cids = implode( ',', $cid );
    // Create sql statement

    $query = 'DELETE FROM #__formmaker_themes'.' WHERE id IN ( '. $cids .' )';
    // Execute query
    $db->setQuery( $query );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";
    }
	
  }
  // After all, redirect again to frontpage
  if($msg)
  $mainframe->redirect( "index.php?option=com_formmaker&task=themes",  $msg);
  else
  $mainframe->redirect( "index.php?option=com_formmaker&task=themes");
}




function save_as_copy(){

	$mainframe = &JFactory::getApplication();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$id 	= $cid[0];
	$row =& JTable::getInstance('formmaker', 'Table');

	// load the row from the db table
	$row->load( $id);

	if(!$row->bind(JRequest::get('post')))

	{

		JError::raiseError(500, $row->getError() );

	}
	
	$row->id='';
	$new=true;
	$row->form = JRequest::getVar( 'form', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->form_front = JRequest::getVar( 'form_front', '','post', 'string', JREQUEST_ALLOWRAW );
	$fid = JRequest::getVar( 'id',0 );

	if(!$row->store()){

		JError::raiseError(500, $row->getError() );

	}
	
	if($new)
	{
		$db =& JFactory::getDBO();
		$db->setQuery("INSERT INTO #__formmaker_views (form_id, views) VALUES('".$row->id."', 0)" ); 
		$db->query();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

	}

		$msg = 'The form has been saved successfully.';

		$link = 'index.php?option=com_formmaker';
		$mainframe->redirect($link, $msg);
		break;
		

}


function save($task){

	$mainframe = &JFactory::getApplication();
	$row =& JTable::getInstance('formmaker', 'Table');

	if(!$row->bind(JRequest::get('post')))

	{

		JError::raiseError(500, $row->getError() );

	}
	$new=(!isset($row->id));
	$row->form = JRequest::getVar( 'form', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->form_front = JRequest::getVar( 'form_front', '','post', 'string', JREQUEST_ALLOWRAW );
	$fid = JRequest::getVar( 'id',0 );

	if(!$row->store()){

		JError::raiseError(500, $row->getError() );

	}
	
	if($new)
	{
		$db =& JFactory::getDBO();
		$db->setQuery("INSERT INTO #__formmaker_views (form_id, views) VALUES('".$row->id."', 0)" ); 
		$db->query();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

	}
	
	switch ($task)

	{

		case 'apply':

		HTML_contact::forchrome($row->id);

		break;

		case 'save_and_new':

		$msg = 'The form has been saved successfully.';

		$link = 'index.php?option=com_formmaker&task=add';
		$mainframe->redirect($link, $msg);
		break;
		
		case 'save':

		$msg = 'The form has been saved successfully.';

		$link = 'index.php?option=com_formmaker';
		$mainframe->redirect($link, $msg);
		break;
		
		case 'return_id':
			return $row->id;
		break;

		default:
		break;

	}

}

function save_themes($task){

	$mainframe = &JFactory::getApplication();
	$row =& JTable::getInstance('formmaker_themes', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}

	switch ($task)

	{
		case 'apply_themes':
		$msg ='Theme has been saved successfully.';
		$link ='index.php?option=com_formmaker&task=edit_themes&cid[]='.$row->id;
		break;

		default:
		$msg = 'Theme has been saved successfully.';
		$link ='index.php?option=com_formmaker&task=themes';
		break;
	}
	
	$mainframe->redirect($link, $msg);

}

function save_form_options($task){

	$mainframe = &JFactory::getApplication();
	$row =& JTable::getInstance('formmaker', 'Table');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	$row->script_mail = JRequest::getVar( 'script_mail', '','post', 'string', JREQUEST_ALLOWRAW );
	$row->script_mail_user = JRequest::getVar( 'script_mail_user', '','post', 'string', JREQUEST_ALLOWRAW );

	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}

	switch ($task)

	{
		case 'apply_form_options':
		$msg ='Form options have been saved successfully.';
		$link ='index.php?option=com_formmaker&task=form_options&cid[]='.$row->id;
		break;
		case 'save_form_options':
		default:
		$msg = 'Form options have been saved successfully.';
		$link ='index.php?option=com_formmaker&task=edit&cid[]='.$row->id;
		break;
	}
	
	$mainframe->redirect($link, $msg);

}

function edit(){
	$db		=& JFactory::getDBO();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$id 	= $cid[0];
	$row =& JTable::getInstance('formmaker', 'Table');

	// load the row from the db table
	$row->load( $id);
		
		$labels= array();
		
		$label_id= array();
		$label_order_original= array();
		$label_type= array();
		
		$label_all	= explode('#****#',$row->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_oder_each=explode('#**label**#', $label_id_each[1]);
			array_push($label_order_original, addslashes($label_oder_each[0]));
			array_push($label_type, $label_oder_each[1]);

		
			
		}
		
	$labels['id']='"'.implode('","',$label_id).'"';
	$labels['label']='"'.implode('","',$label_order_original).'"';
	$labels['type']='"'.implode('","',$label_type).'"';
	
	$query = "SELECT * FROM #__formmaker_themes ORDER BY title";
	$db->setQuery( $query);
	$themes = $db->loadObjectList();
	if($db->getErrorNum()){
		echo $db->stderr();
		return false;
	}
	

	HTML_contact::edit($row, $labels, $themes);

}


function copy_form()
{

	$db		=& JFactory::getDBO();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$id 	= $cid[0];
	$row =& JTable::getInstance('formmaker', 'Table');

	// load the row from the db table
	$row->load( $id);
		
	$mainframe = &JFactory::getApplication();
	
	$row->id='';
	$new=true;

	if(!$row->store()){

		JError::raiseError(500, $row->getError() );

	}
	
	if($new)
	{
		$db =& JFactory::getDBO();
		$db->setQuery("INSERT INTO #__formmaker_views (form_id, views) VALUES('".$row->id."', 0)" ); 
		$db->query();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

	}
	
		$msg = 'The form has been saved successfully.';

		$link = 'index.php?option=com_formmaker';
		$mainframe->redirect($link, $msg);
}



function editSubmit(){

	$db		=& JFactory::getDBO();
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$id 	= $cid[0];
	
	$query = "SELECT * FROM #__formmaker_submits WHERE group_id=".$id;
	$db->setQuery( $query);
	$rows = $db->loadObjectList();
	if($db->getErrorNum()){echo $db->stderr();return false;}
	
	$form =& JTable::getInstance('formmaker', 'Table');
	$form->load( $rows[0]->form_id);
	
		$label_id= array();
		$label_order_original= array();
		$label_type= array();
		$ispaypal=strpos($form->label_order, 'type_paypal_');
		if($form->paypal_mode==1)
			if($ispaypal)
				$form->label_order=$form->label_order."0#**id**#Payment Status#**label**#type_paypal_payment_status#****#";
		
		$label_all	= explode('#****#',$form->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_oder_each=explode('#**label**#', $label_id_each[1]);
			array_push($label_order_original, $label_oder_each[0]);
			array_push($label_type, $label_oder_each[1]);

		
			
		}
	 
	// display function 

	HTML_contact::editSubmit($rows, $label_id ,$label_order_original,$label_type,$ispaypal);

}

function saveSubmit($task){

	$mainframe = &JFactory::getApplication();
	$db		=& JFactory::getDBO();
	$id 	= JRequest::getVar('id');
	$date 	= JRequest::getVar('date');
	$ip 	= JRequest::getVar('ip');
	
	$form_id 	= JRequest::getVar('form_id');
	$form =& JTable::getInstance('formmaker', 'Table');
	$form->load($form_id);
		$label_id= array();
		$label_order_original= array();
		$label_type= array();
		if(strpos($form->label_order, 'type_paypal_'))
		{
			$form->label_order=$form->label_order."0#**id**#Payment Status#**label**#type_paypal_payment_status#****#";
		}

		
		$label_all	= explode('#****#',$form->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_oder_each=explode('#**label**#', $label_id_each[1]);
			array_push($label_order_original, $label_oder_each[0]);
			array_push($label_type, $label_oder_each[1]);

		
			
		}
	
	foreach($label_id as $key => $label_id_1)
	{
		$element_value=JRequest::getVar("submission_".$label_id_1);
		if(isset($element_value))
		{
			$query = "SELECT id FROM #__formmaker_submits WHERE group_id='".$id."' AND element_label='".$label_id_1."'";
			$db->setQuery( $query);
			$result=$db->loadResult();
			if($db->getErrorNum()){	echo $db->stderr();	return false;}
			
			if($label_type[$key]=='type_file_upload')
				$element_value=$element_value."*@@url@@*";
			
			if($result)
			{
				$query = "UPDATE #__formmaker_submits SET `element_value`='".$element_value."' WHERE group_id='".$id."' AND element_label='".$label_id_1."'";
				$db->setQuery( $query);
				$db->query();
				if($db->getErrorNum()){	echo $db->stderr();	return false;}
			}
			else
			{
				$query = "INSERT INTO #__formmaker_submits (form_id, element_label, element_value, group_id, date, ip) VALUES('".$form_id."', '".$label_id_1."', '".$element_value."','".$id."', '".$date."', '".$ip."')" ;
				$db->setQuery( $query);
				$db->query();
				if($db->getErrorNum()){	echo $db->stderr();	return false;}
			}
		}
		else
		{
			$element_value_ch=JRequest::getVar("submission_".$label_id_1.'_0');
			if(isset($element_value_ch))
			{
				for($z=0; $z<21; $z++ )
				{
					$element_value_ch=JRequest::getVar("submission_".$label_id_1.'_'.$z);
					if(isset($element_value_ch))
						$element_value=$element_value.$element_value_ch.'***br***';
					else
						break;
				}
				$query = "SELECT id FROM #__formmaker_submits WHERE group_id='".$id."' AND element_label='".$label_id_1."'";
				$db->setQuery( $query);
				$result=$db->loadResult();
				if($db->getErrorNum()){	echo $db->stderr();	return false;}
				
				if($result)
				{
					$query = "UPDATE #__formmaker_submits SET `element_value`='".$element_value."' WHERE group_id='".$id."' AND element_label='".$label_id_1."'";
					$db->setQuery( $query);
					$db->query();
					if($db->getErrorNum()){	echo $db->stderr();	return false;}
				}
				else
				{
					$query = "INSERT INTO #__formmaker_submits (form_id, element_label, element_value, group_id, date, ip) VALUES('".$form_id."', '".$label_id_1."', '".$element_value."','".$id."', '".$date."', '".$ip."')" ;
					$db->setQuery( $query);
					$db->query();
					if($db->getErrorNum()){	echo $db->stderr();	return false;}
				}
				
			}

		}
		
		
	}
	switch ($task)
	{
		case 'save_submit':
		$msg = 'Submission has been saved successfully.';
		$link ='index.php?option=com_formmaker&task=submits';
		break;
		case 'apply_submit':
		default:
		$msg = 'Submission has been saved successfully.';
		$link ='index.php?option=com_formmaker&task=edit_submit&cid[]='.$id;
		break;
	}
	
	$mainframe->redirect($link, $msg);

}

function form_options_temp(){
	$mainframe = &JFactory::getApplication();
	$row_id=save('return_id');
	$link = 'index.php?option=com_formmaker&task=form_options&cid[]='.$row_id;

	$mainframe->redirect($link);

}


function removeSubmit(){

  $mainframe = &JFactory::getApplication();

  // Initialize variables	

  $db =& JFactory::getDBO();

  // Define cid array variable

  $form_id = JRequest::getVar( 'form_id');
  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );

  // Make sure cid array variable content integer format

  JArrayHelper::toInteger($cid);

  // If any item selected

  if (count( $cid )) {


    $cids = implode( ',', $cid );

    // Create sql statement

    $query = 'DELETE FROM #__formmaker_submits'

    . ' WHERE group_id IN ( '. $cids .' )'

    ;

    // Execute query

    $db->setQuery( $query );

    if (!$db->query()) {

      echo "<script> alert('".$db->getErrorMsg(true)."'); 

      window.history.go(-1); </script>\n";

    }
	
    $query = 'DELETE FROM #__formmaker_sessions'

    . ' WHERE group_id IN ( '. $cids .' )'

    ;

    // Execute query

    $db->setQuery( $query );

    if (!$db->query()) {

      echo "<script> alert('".$db->getErrorMsg(true)."'); 

      window.history.go(-1); </script>\n";

    }
	
	

  }

  // After all, redirect again to frontpage

  $mainframe->redirect( "index.php?option=com_formmaker&task=submits&form_id=".$form_id );


}

function remove(){



  $mainframe = &JFactory::getApplication();

  // Initialize variables	

  $db =& JFactory::getDBO();

  // Define cid array variable

  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );

  // Make sure cid array variable content integer format

  JArrayHelper::toInteger($cid);



  // If any item selected

  if (count( $cid )) {

    // Prepare sql statement, if cid array more than one, 

    // will be "cid1, cid2, ..."

    $cids = implode( ',', $cid );

    // Create sql statement

    $query = 'DELETE FROM #__formmaker' . ' WHERE id IN ( '. $cids .' )'  ;

    // Execute query

    $db->setQuery( $query );

    if (!$db->query()) {

      echo "<script> alert('".$db->getErrorMsg(true)."'); 

      window.history.go(-1); </script>\n";

    }
	
    $query = 'DELETE FROM #__formmaker_views' . ' WHERE form_id IN ( '. $cids .' )'  ;

    // Execute query

    $db->setQuery( $query );

    if (!$db->query()) {

      echo "<script> alert('".$db->getErrorMsg(true)."'); 

      window.history.go(-1); </script>\n";

    }
	

  }

	remove_submits_all( $cids );

  // After all, redirect again to frontpage

  $mainframe->redirect( "index.php?option=com_formmaker" );

}

function remove_submits_all( $cids ){
  $db =& JFactory::getDBO();
	$query = 'DELETE FROM #__formmaker_submits'

    . ' WHERE form_id IN ( '. $cids .' )'

    ;

    // Execute query

    $db->setQuery( $query );

    if (!$db->query()) {

      echo "<script> alert('".$db->getErrorMsg(true)."'); 

      window.history.go(-1); </script>\n";

    }

}

function change( $state=0 ){

  $mainframe = &JFactory::getApplication();



  // Initialize variables

  $db 	=& JFactory::getDBO();



  // define variable $cid from GET

  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );	

  JArrayHelper::toInteger($cid);



  // Check there is/are item that will be changed. 

  //If not, show the error.

  if (count( $cid ) < 1) {

    $action = $state ? 'publish' : 'unpublish';

    JError::raiseError(500, JText::_( 'Select an item 

    to' .$action, true ) );

  }



  // Prepare sql statement, if cid more than one, 

  // it will be "cid1, cid2, cid3, ..."

  $cids = implode( ',', $cid );



  $query = 'UPDATE #__formmaker'

  . ' SET published = ' . (int) $state

  . ' WHERE id IN ( '. $cids .' )'

  ;

  // Execute query

  $db->setQuery( $query );

  if (!$db->query()) {

    JError::raiseError(500, $db->getErrorMsg() );

  }



  if (count( $cid ) == 1) {

    $row =& JTable::getInstance('formmaker', 'Table');

    $row->checkin( intval( $cid[0] ) );

  }



  // After all, redirect to front page

  $mainframe->redirect( 'index.php?option=com_formmaker' );

}

function cancel(){

  $mainframe = &JFactory::getApplication();

  $mainframe->redirect( 'index.php?option=com_formmaker&task=forms' );



}

function cancel_themes(){

  $mainframe = &JFactory::getApplication();
  $mainframe->redirect( 'index.php?option=com_formmaker&task=themes' );
}

function cancelSecondary(){

	$mainframe = &JFactory::getApplication();

	if(JRequest::getVar('id')==0)

	$link = 'index.php?option=com_formmaker&task=add';

	else

	$link = 'index.php?option=com_formmaker&task=edit&cid[]='.JRequest::getVar('id');

	$mainframe->redirect($link);

}

function cancelSubmit(){
	$mainframe = &JFactory::getApplication();
	$link = 'index.php?option=com_formmaker&task=submits';
	$mainframe->redirect($link);

}
		
function select_article(){


	$mainframe = &JFactory::getApplication();
	
	    $db =& JFactory::getDBO();

	$option='com_formmaker';

	$filter_order= $mainframe-> getUserStateFromRequest( $option.'filter_order', 'filter_order','id','cmd' );
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir','','word' );
	$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '','word' );
	$search = $mainframe-> getUserStateFromRequest( $option.'search', 'search','','string' );
	$search = JString::strtolower( $search );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();

	if ( $search ) {

		$where[] = 'title LIKE "%'.$db->escape($search).'%"';

	}	

	

	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

	if ($filter_order == 'id' or $filter_order == 'group_id' or $filter_order == 'group_id' or $filter_order == 'date' or $filter_order == 'ip'){

		$orderby 	= ' ORDER BY id';

	} else {

		$orderby 	= ' ORDER BY '. 

         $filter_order .' '. $filter_order_Dir .', id';

	}	

	

	// get the total number of records

	$query = 'SELECT COUNT(*)'

	. ' FROM #__content'

	. $where

	;

	$db->setQuery( $query );

	$total = $db->loadResult();



	jimport('joomla.html.pagination');

	$pageNav = new JPagination( $total, $limitstart, $limit );	

	$query = "SELECT * FROM #__content". $where. $orderby;

	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );

	$rows = $db->loadObjectList();

	if($db->getErrorNum()){

		echo $db->stderr();

		return false;

	}



	// table ordering

	$lists['order_Dir']	= $filter_order_Dir;

	$lists['order']		= $filter_order;	



	// search filter	

        $lists['search']= $search;	

	

    // display function

	HTML_contact::select_article($rows, $pageNav, $lists);

}
?>