<?php
 /**
 * @package Form Maker Lite Module
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

$lang = & JFactory::getLanguage();
$lang->load('com_formmaker',JPATH_BASE);

class modFormmaker
{	
	 function load($form)
	{
		$result = modFormmaker::showform( $form);
		if(!$result)
			return;
			
		$ok		= modFormmaker::savedata($form, $result[0] );

		if(is_numeric($ok))		
			modFormmaker::remove($ok);
		
		return modFormmaker::defaultphp($result[0], $result[1], $result[2], $result[3], $result[4], $form,$ok);
			
	}
	// This is always going to get the first instance of the module type unless
	// there is a title.
	 function showform($id)
	{
			$input_get = JFactory::getApplication()->input;

		$Itemid=$input_get->getString('Itemid'.$id);

		$db =& JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__formmaker WHERE id=".$db->escape($id) ); 
		$row = $db->loadObject();
		if ($db->getErrorNum())	{echo $db->stderr();return false;}	
		
		if(!$row)
			return false;
			
		$db->setQuery("SELECT css FROM #__formmaker_themes WHERE id=".$db->escape($row->theme) ); 
		$form_theme = $db->loadResult();
		if ($db->getErrorNum())	{echo $db->stderr(); return false;}	
		
		$label_id= array();
		$label_type= array();
			
		$label_all	= explode('#****#',$row->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_order_each=explode('#**label**#', $label_id_each[1]);
			
			array_push($label_type, $label_order_each[1]);
		}
		
		return array($row, $Itemid, $label_id, $label_type ,$form_theme);
	}

	 function savedata($id, $form)
	{
		$input_get = JFactory::getApplication()->input;
		$all_files=array();
		$db =& JFactory::getDBO();
		@session_start();

		$captcha_input=$input_get->getString("captcha_input");
		$recaptcha_response_field=$input_get->getString("recaptcha_response_field");
		$counter=$input_get->getString("counter".$id);
		if(isset($counter))
		{	
			if (isset($captcha_input))
			{				
				$session_wd_captcha_code=isset($_SESSION[$id.'_wd_captcha_code'])?$_SESSION[$id.'_wd_captcha_code']:'-';

				if($captcha_input==$session_wd_captcha_code)
				{
					$all_files=modFormmaker::save_db($counter, $id);
					if(is_numeric($all_files))		
						modFormmaker::remove($all_files);
					else
						if(isset($counter))
							modFormmaker::gen_mail($counter, $all_files, $id);

				}
				else
				{
							echo "<script> alert('".JText::_('WDF_INCORRECT_SEC_CODE')."');
						</script>";
				}
			}	
			
			else
				if(isset($recaptcha_response_field))
				{	
				$privatekey = $form->private_key;
	
					$resp = recaptcha_check_answer ($privatekey,
													$_SERVER["REMOTE_ADDR"],
													$_POST["recaptcha_challenge_field"],
													$recaptcha_response_field);
					if($resp->is_valid)
					{
						$all_files=modFormmaker::save_db($counter, $id);
						if(is_numeric($all_files))		
							modFormmaker::remove($all_files);
						else
							if(isset($counter))
								modFormmaker::gen_mail($counter, $all_files, $id);
	
					}
					else
					{
								echo "<script> alert('".JText::_('WDF_INCORRECT_SEC_CODE')."');
							</script>";
					}
				}	
			
				else	
				{
					$all_files=modFormmaker::save_db($counter, $id);
					if(is_numeric($all_files))		
						modFormmaker::remove($all_files);
					else
						if(isset($counter))
							modFormmaker::gen_mail($counter, $all_files, $id);
		
				}
	

			return $all_files;
		}

		return $all_files;
			
			
	}
	
	 function save_db($counter,$id)
	{
		$input_get = JFactory::getApplication()->input;
		$chgnac=true;	
		$all_files=array();
		
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_formmaker'.DS.'tables');
		$form =& JTable::getInstance('formmaker', 'Table');
		$form->load( $id);
		
		$label_id= array();
		$label_label= array();
		$label_type= array();
			
		$label_all	= explode('#****#',$form->label_order);
		$label_all 	= array_slice($label_all,0, count($label_all)-1);   
		
		foreach($label_all as $key => $label_each) 
		{
			$label_id_each=explode('#**id**#',$label_each);
			array_push($label_id, $label_id_each[0]);
			
			$label_order_each=explode('#**label**#', $label_id_each[1]);
			
			array_push($label_label, $label_order_each[0]);
			array_push($label_type, $label_order_each[1]);
		}
		
		
		
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT MAX( group_id ) FROM #__formmaker_submits" ); 
		$db->query();
		$max = $db->loadResult();
		foreach($label_type as $key => $type)
		{
			$value='';
			if($type=="type_submit_reset" or $type=="type_map" or $type=="type_editor" or  $type=="type_captcha" or  $type=="type_recaptcha" or  $type=="type_button")
				continue;

			$i=$label_id[$key];
			
			if($type!="type_address")
			{
				$deleted=$input_get->getString($i."_type".$id);
				if(!isset($deleted))
					break;
			}
				
			switch ($type)
			{
				case 'type_text':
				case 'type_password':
				case 'type_textarea':
				case "type_submitter_mail":
				case "type_date":
				case "type_own_select":					
				case "type_country":				
				case "type_number":				
				{
					$value=$input_get->getString($i."_element".$id);
					break;
				}
				
				case "type_mark_map":				
				{
					$value=$input_get->getString($i."_long".$id).'***map***'.$input_get->getString($i."_lat".$id);
					break;
				}
									
				case "type_date_fields":
				{
					$value=$input_get->getString($i."_day".$id).'-'.$input_get->getString($i."_month".$id).'-'.$input_get->getString($i."_year".$id);
					break;
				}
				
				case "type_time":
				{
					$ss=$input_get->getString($i."_ss".$id);
					if(isset($ss))
						$value=$input_get->getString($i."_hh".$id).':'.$input_get->getString($i."_mm".$id).':'.$input_get->getString($i."_ss".$id);
					else
						$value=$input_get->getString($i."_hh".$id).':'.$input_get->getString($i."_mm".$id);
							
					$am_pm=$input_get->getString($i."_am_pm".$id);
					if(isset($am_pm))
						$value=$value.' '.$input_get->getString($i."_am_pm".$id);
						
					break;
				}
				
				case "type_phone":
				{
					$value=$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id);
						
					break;
				}
	
				case "type_name":
				{
					$element_title=$input_get->getString($i."_element_title".$id);
					if(isset($element_title))
						$value=$input_get->getString($i."_element_title".$id).' '.$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id).' '.$input_get->getString($i."_element_middle".$id);
					else
						$value=$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id);
						
					break;
				}
	
				case "type_file_upload":
				{
					$file = JRequest::getVar($i.'_file'.$id, null, 'files', 'array');
					if($file['name'])
					{	
						$untilupload = $form->form;
						
						$pos1 = strpos($untilupload, "***destinationskizb".$i."***");
						$pos2 = strpos($untilupload, "***destinationverj".$i."***");
						$destination = substr($untilupload, $pos1+(23+(strlen($i)-1)), $pos2-$pos1-(23+(strlen($i)-1)));
						$pos1 = strpos($untilupload, "***extensionskizb".$i."***");
						$pos2 = strpos($untilupload, "***extensionverj".$i."***");
						$extension = substr($untilupload, $pos1+(21+(strlen($i)-1)), $pos2-$pos1-(21+(strlen($i)-1)));
						$pos1 = strpos($untilupload, "***max_sizeskizb".$i."***");
						$pos2 = strpos($untilupload, "***max_sizeverj".$i."***");
						$max_size = substr($untilupload, $pos1+(20+(strlen($i)-1)), $pos2-$pos1-(20+(strlen($i)-1)));
						
						$fileName = $file['name'];
						/*$destination = JPATH_SITE.DS.$input_get->getString($i.'_destination');
						$extension = $input_get->getString($i.'_extension');
						$max_size = $input_get->getString($i.'_max_size');*/
					
						$fileSize = $file['size'];

						if($fileSize > $max_size*1024)
						{
							echo "<script> alert('".JText::sprintf('WDF_FILE_SIZE_ERROR',$max_size)."');</script>";
							return ($max+1);
						}
						
						$uploadedFileNameParts = explode('.',$fileName);
						$uploadedFileExtension = array_pop($uploadedFileNameParts);
						$to=strlen($fileName)-strlen($uploadedFileExtension)-1;
						
						$fileNameFree= substr($fileName,0, $to);
						$invalidFileExts = explode(',', $extension);
						$extOk = false;

						foreach($invalidFileExts as $key => $value)
						{
						if(  is_numeric(strpos(strtolower($value), strtolower($uploadedFileExtension) )) )
							{
								$extOk = true;
							}
						}
						 
						if ($extOk == false) 
						{
							echo "<script> alert('".JText::_('WDF_FILE_TYPE_ERROR')."');</script>";
							return ($max+1);
						}
						
						$fileTemp = $file['tmp_name'];
						$p=1;
						while(file_exists( $destination.DS.$fileName))
						{
						$to=strlen($file['name'])-strlen($uploadedFileExtension)-1;
						$fileName= substr($fileName,0, $to).'('.$p.').'.$uploadedFileExtension;
						$p++;
						}
						
						if(!JFile::upload($fileTemp, $destination.DS.$fileName)) 
						{	
							echo "<script> alert('".JText::_('WDF_FILE_MOVING_ERROR')."');</script>";
							return ($max+1);
						}

						$value= JURI::root(true).'/'.$destination.'/'.$fileName.'*@@url@@*';
		
						$file['tmp_name']=$destination.DS.$fileName;
						array_push($all_files,$file);

					}
					break;
				}
				
				case 'type_address':
				{
					$value='*#*#*#';
					$element=$input_get->getString($i."_street1".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_street1".$id);
						break;
					}
					
					$element=$input_get->getString($i."_street2".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_street2".$id);
						break;
					}
					
					$element=$input_get->getString($i."_city".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_city".$id);
						break;
					}
					
					$element=$input_get->getString($i."_state".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_state".$id);
						break;
					}
					
					$element=$input_get->getString($i."_postal".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_postal".$id);
						break;
					}
					
					$element=$input_get->getString($i."_country".$id);
					if(isset($element))
					{
						$value=$input_get->getString($i."_country".$id);
						break;
					}
					
					break;
				}
				
				case "type_hidden":				
				{
					$value=$input_get->getString($label_label[$key]);
					break;
				}
				
				case "type_radio":				
				{
					$element=$input_get->getString($i."_other_input".$id);
					if(isset($element))
					{
						$value=$element;	
						break;
					}
					
					$value=$input_get->getString($i."_element".$id);
					break;
				}
				
				case "type_checkbox":				
				{
					$start=-1;
					$value='';
					for($j=0; $j<100; $j++)
					{
					
						$element=$input_get->getString($i."_element".$id.$j);
		
						if(isset($element))
						{
							$start=$j;
							break;
						}
					}
						
					$other_element_id=-1;
					$is_other=$input_get->getString($i."_allow_other".$id);
					if($is_other=="yes")
					{
						$other_element_id=$input_get->getString($i."_allow_other_num".$id);
					}
					
					if($start!=-1)
					{
						for($j=$start; $j<100; $j++)
						{
							$element=$input_get->getString($i."_element".$id.$j);
							if(isset($element))
							if($j==$other_element_id)
							{
								$value=$value.$input_get->getString($i."_other_input".$id).'***br***';
							}
							else
							
								$value=$value.$input_get->getString($i."_element".$id.$j).'***br***';
						}
					}
					
					break;
				}
				
			}
	
			if($type=="type_address")
				if(	$value=='*#*#*#')
					break;

			$unique_element=$input_get->getString($i."_unique".$id);
			if($unique_element=='yes')
			{
				$db->setQuery("SELECT id FROM #__formmaker_submits WHERE form_id='".$db->escape($id)."' and element_label='".$db->escape($i)."' and element_value='".$db->escape(addslashes($value))."'");					
				$unique = $db->loadResult();
				if ($db->getErrorNum()){echo $db->stderr();	return false;}
	
				if ($unique) 
				{
					echo "<script> alert('".JText::sprintf('WDF_UNIQUE', '"'.$label_label[$key].'"')	."');</script>";		
					return ($max+1);
				}
			}

			$ip=$_SERVER['REMOTE_ADDR'];
			
			$db->setQuery("INSERT INTO #__formmaker_submits (form_id, element_label, element_value, group_id, date, ip) VALUES('".$id."', '".$i."', '".addslashes($value)."','".($max+1)."', now(), '".$ip."')" ); 
			$rows = $db->query();
			if ($db->getErrorNum()){echo $db->stderr();	return false;}
			$chgnac=false;
		}

		if($chgnac)
		{		$mainframe = &JFactory::getApplication();
	
				if(count($all_files)==0)
					$mainframe->redirect($_SERVER["REQUEST_URI"], addslashes(JText::_('WDF_EMPTY_SUBMIT')));
		}
		
		return $all_files;
	}
	
	 function gen_mail($counter, $all_files, $id)
	{
		$input_get = JFactory::getApplication()->input;
		@session_start();
		$mainframe = &JFactory::getApplication();
		$Itemid=$input_get->getString('Itemid'.$id);
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_formmaker'.DS.'tables');
		$row =& JTable::getInstance('formmaker', 'Table');
		$row->load( $id);
		
			$cc=array();
			$label_order_original= array();
			$label_order_ids= array();
			
			$label_all	= explode('#****#',$row->label_order);
			$label_all 	= array_slice($label_all,0, count($label_all)-1);   
			foreach($label_all as $key => $label_each) 
			{
				$label_id_each=explode('#**id**#',$label_each);
				$label_id=$label_id_each[0];
				array_push($label_order_ids,$label_id);
				
				$label_oder_each=explode('#**label**#', $label_id_each[1]);							
				$label_order_original[$label_id]=$label_oder_each[0];
			}
		
			$list='<table border="1" cellpadding="3" cellspacing="0" style="width:600px;">';
			foreach($label_order_ids as $key => $label_order_id)
			{
				$i=$label_order_id;
				$type=$input_get->getString($i."_type".$id);
				if(isset($type))
				if($type!="type_map" and  $type!="type_submit_reset" and  $type!="type_editor" and  $type!="type_captcha" and  $type!="type_recaptcha" and  $type!="type_button")
				{	
					$element_label=$label_order_original[$i];
							
					switch ($type)
					{
						case 'type_text':
						case 'type_password':
						case 'type_textarea':
						case "type_date":
						case "type_own_select":					
						case "type_country":				
						case "type_number":	
						{
							$element=$input_get->getString($i."_element".$id);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">'.$element.'</pre></td></tr>';					
							}
							break;
						
						
						}
						
						case "type_hidden":				
						{
							$element=$input_get->getString($element_label);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">'.$element.'</pre></td></tr>';					
							}
							break;
						}
						
						case "type_mark_map":
						{
							$element=$input_get->getString($i."_long".$id);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >Longitude:'.$input_get->getString($i."_long".$id).'<br/>Latitude:'.$input_get->getString($i."_lat".$id).'</td></tr>';
							}
							break;		
						}
											
						case "type_submitter_mail":
						{
							$element=$input_get->getString($i."_element".$id);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">'.$element.'</pre></td></tr>';					
								if($input_get->getString($i."_send".$id)=="yes")
									array_push($cc, $element);
							}
							break;		
						}
						
						case "type_time":
						{
							
							$hh=$input_get->getString($i."_hh".$id);
							if(isset($hh))
							{
								$ss=$input_get->getString($i."_ss".$id);
								if(isset($ss))
									$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_hh".$id).':'.$input_get->getString($i."_mm".$id).':'.$input_get->getString($i."_ss".$id);
								else
									$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_hh".$id).':'.$input_get->getString($i."_mm".$id);
								$am_pm=$input_get->getString($i."_am_pm".$id);
								if(isset($am_pm))
									$list=$list.' '.$input_get->getString($i."_am_pm".$id).'</td></tr>';
								else
									$list=$list.'</td></tr>';
							}
								
							break;
						}
						
						case "type_phone":
						{
							$element_first=$input_get->getString($i."_element_first".$id);
							if(isset($element_first))
							{
									$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id).'</td></tr>';
							}	
							break;
						}
						
						case "type_name":
						{
							$element_first=$input_get->getString($i."_element_first".$id);
							if(isset($element_first))
							{
								$element_title=$input_get->getString($i."_element_title".$id);
								if(isset($element_title))
									$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_element_title".$id).' '.$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id).' '.$input_get->getString($i."_element_middle".$id).'</td></tr>';
								else
									$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_element_first".$id).' '.$input_get->getString($i."_element_last".$id).'</td></tr>';
							}	   
							break;		
						}
						
						case "type_address":
						{
							$street1=$input_get->getString($i."_street1".$id);
							if(isset($street1))
							{
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_street1".$id).'</td></tr>';
								$i++;
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_street2".$id).'</td></tr>';
								$i++;
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_city".$id).'</td></tr>';
								$i++;
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_state".$id).'</td></tr>';
								$i++;
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_postal".$id).'</td></tr>';
								$i++;
								$list=$list.'<tr valign="top"><td >'.$label_order_original[$i].'</td><td >'.$input_get->getString($i."_country".$id).'</td></tr>';
								$i++;			
							}		
							break;
						}
						
						case "type_date_fields":
						{
							$day=$input_get->getString($i."_day".$id);
							if(isset($day))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_day".$id).'-'.$input_get->getString($i."_month".$id).'-'.$input_get->getString($i."_year".$id).'</td></tr>';
							}
							break;
						}
						
						case "type_radio":
						{
							$element=$input_get->getString($i."_other_input".$id);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >'.$input_get->getString($i."_other_input".$id).'</td></tr>';
								break;
							}	
							
							$element=$input_get->getString($i."_element".$id);
							if(isset($element))
							{
								$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">'.$element.'</pre></td></tr>';					
							}
							break;	
						}
						
						case "type_checkbox":
						{
							$list=$list.'<tr valign="top"><td >'.$element_label.'</td><td >';
						
							$start=-1;
							for($j=0; $j<100; $j++)
							{
								$element=$input_get->getString($i."_element".$id.$j);
								if(isset($element))
								{
									$start=$j;
									break;
								}
							}	
							
							$other_element_id=-1;
							$is_other=$input_get->getString($i."_allow_other".$id);
							if($is_other=="yes")
							{
								$other_element_id=$input_get->getString($i."_allow_other_num".$id);
							}
							
					
							if($start!=-1)
							{
								for($j=$start; $j<100; $j++)
								{
									
									$element=$input_get->getString($i."_element".$id.$j);
									if(isset($element))
									if($j==$other_element_id)
									{
										$list=$list.$input_get->getString($i."_other_input".$id).'<br>';
									}
									else
									
										$list=$list.$input_get->getString($i."_element".$id.$j).'<br>';
								}
								$list=$list.'</td></tr>';
							}
										
							
							break;
						}
						default: break;
					}
				}
					
						
					
				
				
			}
			
			$list=$list.'</table>';
			$list = wordwrap($list, 70, "\n", true);

							$config =& JFactory::getConfig();
							$site_mailfrom=$config->get( 'mailfrom' );		
							$site_fromname=$config->get( 'fromname' );					
							for($k=0;$k<count($all_files);$k++)
								$attachment[]=array($all_files[$k]['tmp_name'], $all_files[$k]['name'], $all_files[$k]['name'] );
							
							if(isset($cc[0]))
							{
								foreach	($cc as $c)	
								{	
									if($c)
									{
										 $from      = $site_mailfrom;
										 $fromname  = $site_fromname; 
										 $recipient = $c;
										 $subject   = $row->title;
										 $body      = $row->script_user1.'<br>'.$list.'<br>'.$row->script_user2;
										 $mode      = 1; 
									$send=modFormmaker::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cca, $bcc, $attachment, $replyto, $replytoname);  
									}	
									
									
									if($row->mail)
									{

										if($c)
										{
											 $from      = $c;
											 $fromname  = $c; 
										}
										else
										{
											 $from      = $site_mailfrom;
											 $fromname  = $site_fromname; 
										}
											 $recipient = $row->mail;
											 $subject   = $row->title;
											 $body      = $row->script1.'<br>'.$list.'<br>'.$row->script2;
											 $mode      = 1; 

										$send=modFormmaker::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cca, $bcc, $attachment, $replyto, $replytoname);  
									}
								}
							}
							else 
							{ 
								if($row->mail)
								{

								 $from      = $site_mailfrom;
								 $fromname  = $site_fromname; 
								 $recipient = $row->mail;
								 $subject     = $row->title;
								 $body      = $row->script1.'<br>'.$list.'<br>'.$row->script2;
								 $mode        = 1; 
            
								 $send=modFormmaker::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cca, $bcc, $attachment, $replyto, $replytoname); 
								} 
							}
									
		if($row->mail)
			{
				if ( $send !== true ) 
					$msg=JText::_('WDF_MAIL_SEND_ERROR');
				else 
					$msg=JText::_('WDF_MAIL_SENT');
			}
		else	
			$msg=JText::_('WDF_SUBMITTED');
									
		switch($row->submit_text_type)
		{
					case "2":
					{
						$mainframe->redirect("index.php?option=com_content&view=article&id=".$row->article_id."&Itemid=".$Itemid, $msg);
						break;
					}
					case "3":
					{
						$_SESSION['show_submit_text'.$id]=1;
						$mainframe->redirect($_SERVER["REQUEST_URI"], $msg);
						break;
					}											
					case "4":
					{
						$mainframe->redirect($row->url, $msg);
						break;
					}
					default:
					{
						$mainframe->redirect($_SERVER["REQUEST_URI"], $msg);
						break;
					}
		}														
	}
	


	 function sendMail(&$from, &$fromname, &$recipient, &$subject, &$body, &$mode=0, &$cc=null, &$bcc=null, &$attachment=null, &$replyto=null, &$replytoname=null)
    {
		$input_get = JFactory::getApplication()->input;
				$recipient=explode (',', str_replace(' ', '', $recipient ));
                // Get a JMail instance
                $mail = &JFactory::getMailer();
 
                $mail->setSender(array($from, $fromname));
                $mail->setSubject($subject);
                $mail->setBody($body);
 
                // Are we sending the email as HTML?
                if ($mode) {
                        $mail->IsHTML(true);
                }
 
                $mail->addRecipient($recipient);
                $mail->addCC($cc);
                $mail->addBCC($bcc);
				
				if($attachment)
					foreach($attachment as $attachment_temp)
					{
						$mail->AddEmbeddedImage($attachment_temp[0], $attachment_temp[1], $attachment_temp[2]);
					}
 
                // Take care of reply email addresses
                if (is_array($replyto)) {
                        $numReplyTo = count($replyto);
                        for ($i=0; $i < $numReplyTo; $i++){
                                $mail->addReplyTo(array($replyto[$i], $replytoname[$i]));
                        }
                } elseif (isset($replyto)) {
                        $mail->addReplyTo(array($replyto, $replytoname));
                }
 
                return  $mail->Send();
        }
		
	 function remove($group_id)
	{
		$input_get = JFactory::getApplication()->input;
		$db =& JFactory::getDBO();
		$db->setQuery('DELETE FROM #__formmaker_submits WHERE group_id="'.$db->escape($group_id).'"');
		$db->query();
	}
	
	 function defaultphp($row, $Itemid, $label_id,$label_type, $form_theme, $id, $ok)
	{
		ob_start();
        static $embedded;
        if(!$embedded)
        {
            $embedded=true;
        }
	?>
    
<?php 
$input_get = JFactory::getApplication()->input;

@session_start();
$mainframe = &JFactory::getApplication();



if(isset($_SESSION['show_submit_text'.$id]))
	if($_SESSION['show_submit_text'.$id]==1)
	{
		$_SESSION['show_submit_text'.$id]=0;
		echo $row->submit_text;
		return;
	}
	
		$db =& JFactory::getDBO();
		$db->setQuery("UPDATE #__formmaker_views SET  views=views+1 where form_id=".$db->escape($id) ); 
		$db->query();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		

		$document =& JFactory::getDocument();

		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';
		JHTML::_('behavior.tooltip');	
		JHTML::_('behavior.calendar');
$editor	=& JFactory::getEditor('tinymce');

		$document->addScript(JURI::root(true).'/components/com_formmaker/views/formmaker/tmpl/if_gmap.js');
		$document->addScript( JURI::root(true).'/components/com_formmaker/views/formmaker/tmpl/main.js');
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false');

		
			$article=$row->article_id;
			echo '<script type="text/javascript">'.str_replace('form_id_temp', $id,$row->javascript).'</script>';
	
			$css_rep1=array("[SITE_ROOT]", "}");
			$css_rep2=array(JURI::root(true), "}#form".$id." ");
			$order   = array("\r\n", "\n", "\r");
			$form_theme=str_replace($order,'',$form_theme);
			$form_theme=str_replace($css_rep1,$css_rep2,$form_theme);
			$form_theme="#form".$id.' '.$form_theme;

			echo '<style>'.$form_theme.'</style>';
			

//			echo '<h3>'.$row->title.'</h3><br />';
?>
<form name="form<?php echo $id; ?>" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" id="form<?php echo $id; ?>" enctype="multipart/form-data" onsubmit="check_required('submit', '<?php echo $id; ?>'); return false;">
<div id="<?php echo $id; ?>pages" class="wdform_page_navigation" show_title="<?php echo $row->show_title; ?>" show_numbers="<?php echo $row->show_numbers; ?>" type="<?php echo $row->pagination; ?>"></div>
<input type="hidden" id="counter<?php echo $id ?>" value="<?php echo $row->counter?>" name="counter<?php echo $id ?>" />
<input type="hidden" id="Itemid<?php echo $id ?>" value="<?php echo $Itemid?>" name="Itemid<?php echo $id ?>" />

<?php
//inch@ petq chi raplace minchev form@ tpi			
			
			$rep1=array(
			"<!--repstart-->Title<!--repend-->",
			"<!--repstart-->First<!--repend-->",
			"<!--repstart-->Last<!--repend-->",
			"<!--repstart-->Middle<!--repend-->",
			"<!--repstart-->January<!--repend-->",
			"<!--repstart-->February<!--repend-->",
			"<!--repstart-->March<!--repend-->",
			"<!--repstart-->April<!--repend-->",
			"<!--repstart-->May<!--repend-->",
			"<!--repstart-->June<!--repend-->",
			"<!--repstart-->July<!--repend-->",
			"<!--repstart-->August<!--repend-->",
			"<!--repstart-->September<!--repend-->",
			"<!--repstart-->October<!--repend-->",
			"<!--repstart-->November<!--repend-->",
			"<!--repstart-->December<!--repend-->",
			"<!--repstart-->Street Address<!--repend-->",
			"<!--repstart-->Street Address Line 2<!--repend-->",
			"<!--repstart-->City<!--repend-->",
			"<!--repstart-->State / Province / Region<!--repend-->",
			"<!--repstart-->Postal / Zip Code<!--repend-->",
			"<!--repstart-->Country<!--repend-->",
			"<!--repstart-->Area Code<!--repend-->",
			"<!--repstart-->Phone Number<!--repend-->",
			'class="captcha_img"',
			'components/com_formmaker/images/refresh.png',
			'form_id_temp',
			'../index.php?option=com_formmaker&amp;view=wdcaptcha',
			'style="padding-right:170px"');
			
			$rep2=array(
			JText::_("WDF_NAME_TITLE_LABEL"),
			JText::_("WDF_FIRST_NAME_LABEL"),
			JText::_("WDF_LAST_NAME_LABEL"),
			JText::_("WDF_MIDDLE_NAME_LABEL"),
			JText::_("January"),
			JText::_("February"),
			JText::_("March"),
			JText::_("April"),
			JText::_("May"),
			JText::_("June"),
			JText::_("July"),
			JText::_("August"),
			JText::_("September"),
			JText::_("October"),
			JText::_("November"),
			JText::_("December"),
			JText::_("WDF_STREET_ADDRESS"),
			JText::_("WDF_STREET_ADDRESS2"),
			JText::_("WDF_CITY"),
			JText::_("WDF_STATE"),
			JText::_("WDF_POSTAL"),
			JText::_("WDF_COUNTRY"),
			JText::_("WDF_AREA_CODE"),
			JText::_("WDF_PHONE_NUMBER"),
			'class="captcha_img" style="display:none"',
			'administrator/components/com_formmaker/images/refresh.png',
			$id,
			'index.php?option=com_formmaker&amp;view=wdcaptcha',
			'');
			
			$untilupload = str_replace($rep1,$rep2,$row->form_front);
			while(strpos($untilupload, "***destinationskizb")>0)
			{
				$pos1 = strpos($untilupload, "***destinationskizb");
				$pos2 = strpos($untilupload, "***destinationverj");
				$untilupload=str_replace(substr($untilupload, $pos1, $pos2-$pos1+22), "", $untilupload);
			}
echo $untilupload;

$is_recaptcha=false;
	
?>
<script type="text/javascript">
//genid='<?php echo $id ?>';
//genform_view='<?php echo $id ?>form_view';
//genpage_nav='<?php echo $id ?>page_nav';
//genpages='<?php echo $id ?>pages';
WDF_FILE_TYPE_ERROR 	= '<?php echo JText::_("WDF_FILE_TYPE_ERROR"); ?>';
WDF_INVALID_EMAIL 		= '<?php echo JText::_("WDF_INVALID_EMAIL"); ?>';
REQUEST_URI				= "<?php echo $_SERVER['REQUEST_URI'] ?>";
ReqFieldMsg				='<?php echo addslashes(JText::sprintf('WDF_REQUIRED_FIELD', '`FIELDNAME`')) ?>';  
JURI_ROOT				='<?php echo JURI::root(true) ?>';  


function formOnload<?php echo $id; ?>()
{
	//enable maps and refresh captcha
<?php 
	foreach($label_type as $key => $type)
	{
		switch ($type)
		{
			case 'type_map':?>
		
	if(document.getElementById("<?php echo $label_id[$key] ?>_element<?php echo $id ?>"))
		{
			if_gmap_init(<?php echo $label_id[$key] ?>, <?php echo $id ?>);
			for(q=0; q<20; q++)
				if(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("long"+q))
				{
				
					w_long=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("long"+q));
					w_lat=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("lat"+q));
					w_info=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("info"+q));
					add_marker_on_map(<?php echo $label_id[$key] ?>,q, w_long, w_lat, w_info, <?php echo $id ?>,false);
				}
		}
<?php
			break;
	
			case 'type_mark_map':?>
	if(document.getElementById("<?php echo $label_id[$key] ?>_element<?php echo $id ?>"))
	if(!document.getElementById("<?php echo $label_id[$key] ?>_long<?php echo $id ?>"))	
	{      	
	
		var longit = document.createElement('input');
         	longit.setAttribute("type", 'hidden');
         	longit.setAttribute("id", '<?php echo $label_id[$key] ?>_long<?php echo $id ?>');
         	longit.setAttribute("name", '<?php echo $label_id[$key] ?>_long<?php echo $id ?>');

		var latit = document.createElement('input');
         	latit.setAttribute("type", 'hidden');
         	latit.setAttribute("id", '<?php echo $label_id[$key] ?>_lat<?php echo $id ?>');
         	latit.setAttribute("name", '<?php echo $label_id[$key] ?>_lat<?php echo $id ?>');

		document.getElementById("<?php echo $label_id[$key] ?>_element_section<?php echo $id ?>").appendChild(longit);
		document.getElementById("<?php echo $label_id[$key] ?>_element_section<?php echo $id ?>").appendChild(latit);
	
		if_gmap_init(<?php echo $label_id[$key] ?>, <?php echo $id ?>);
		
		w_long=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("long0"));
		w_lat=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("lat0"));
		w_info=parseFloat(document.getElementById(<?php echo $label_id[$key] ?>+"_element"+<?php echo $id ?>).getAttribute("info0"));
		longit.value=w_long;
		latit.value=w_lat;
		add_marker_on_map(<?php echo $label_id[$key] ?>,0, w_long, w_lat, w_info, <?php echo $id ?>, true);
		
	}
<?php			break;
			
			case 'type_date':?>
	if(document.getElementById("<?php echo $label_id[$key] ?>_element<?php echo $id ?>"))
			Calendar.setup({
						inputField: "<?php echo $label_id[$key] ?>_element<?php echo $id ?>",
						ifFormat: document.getElementById("<?php echo $label_id[$key] ?>_button<?php echo $id ?>").getAttribute('format'),
						button: "<?php echo $label_id[$key] ?>_button<?php echo $id ?>",
						align: "Tl",
						singleClick: true,
						firstDay: 0
						});
			
			
<?php
			break;
	
			case 'type_captcha':?>
	if(document.getElementById('_wd_captcha<?php echo $id ?>'))
		captcha_refresh('_wd_captcha', '<?php echo $id ?>');
<?php
			break;
			
			case 'type_recaptcha':
			$is_recaptcha=true;
			
			break;
	
	
			case 'type_radio':
			case 'type_checkbox':?>
	if(document.getElementById('<?php echo $label_id[$key] ?>_randomize<?php echo $id ?>'))
		if(document.getElementById('<?php echo $label_id[$key] ?>_randomize<?php echo $id ?>').value=="yes")
			choises_randomize('<?php echo $label_id[$key] ?>', '<?php echo $id ?>');
<?php
			break;
	
			default:
			break;
		}
	}

?>
	if(window.before_load)
	{
		before_load();
	}	
}

function formAddToOnload<?php echo $id ?>()
{ 
	if(formOldFunctionOnLoad<?php echo $id ?>){ formOldFunctionOnLoad<?php echo $id ?>(); }
	formOnload<?php echo $id ?>();
}

function formLoadBody<?php echo $id ?>()
{
	formOldFunctionOnLoad<?php echo $id ?> = window.onload;
	window.onload = formAddToOnload<?php echo $id ?>;
}

var formOldFunctionOnLoad<?php echo $id ?> = null;
formLoadBody<?php echo $id ?>();

<?php

$captcha_input=$input_get->getString("captcha_input");
$recaptcha_response_field=$input_get->getString("recaptcha_response_field");
$counter=$input_get->getString("counter".$id);
$old_key=-1;
if(isset($counter))
{
	foreach($label_type as $key => $type)
	{
			switch ($type)
			{
			case "type_text":
			case "type_number":		
			case "type_submitter_mail":{
								echo 
	"if(document.getElementById('".$label_id[$key]."_element".$id."'))
		if(document.getElementById('".$label_id[$key]."_element".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element".$id))."')
		{	document.getElementById('".$label_id[$key]."_element".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element".$id))."';
			document.getElementById('".$label_id[$key]."_element".$id."').className='input_active';
		}
	";
								break;
							}
									
			case "type_textarea":{
			$order   = array("\r\n", "\n", "\r");
								echo 
	"if(document.getElementById('".$label_id[$key]."_element".$id."'))
		if(document.getElementById('".$label_id[$key]."_element".$id."').title!='".str_replace($order,'\n',addslashes($input_get->getString($label_id[$key]."_element".$id)))."')
		{	document.getElementById('".$label_id[$key]."_element".$id."').innerHTML='".str_replace($order,'\n',addslashes($input_get->getString($label_id[$key]."_element".$id)))."';
			document.getElementById('".$label_id[$key]."_element".$id."').className='input_active';
		}
	";
								break;
							}
			case "type_name":{
								$element_title=$input_get->getString($label_id[$key]."_element_title".$id);
								if(isset($element_title))
								{
									echo 
	"if(document.getElementById('".$label_id[$key]."_element_first".$id."'))
	{
		if(document.getElementById('".$label_id[$key]."_element_title".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_title".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_title".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_title".$id))."';
			document.getElementById('".$label_id[$key]."_element_title".$id."').className='input_active';
		}
		
		if(document.getElementById('".$label_id[$key]."_element_first".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_first".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."';
			document.getElementById('".$label_id[$key]."_element_first".$id."').className='input_active';
		}
		
		if(document.getElementById('".$label_id[$key]."_element_last".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_last".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."';
			document.getElementById('".$label_id[$key]."_element_last".$id."').className='input_active';
		}
		
		if(document.getElementById('".$label_id[$key]."_element_middle".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_middle".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_middle".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_middle".$id))."';
			document.getElementById('".$label_id[$key]."_element_middle".$id."').className='input_active';
		}
		
	}";
								}
								else
								{
								echo 
	"if(document.getElementById('".$label_id[$key]."_element_first".$id."'))
	{
		
		if(document.getElementById('".$label_id[$key]."_element_first".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_first".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."';
			document.getElementById('".$label_id[$key]."_element_first".$id."').className='input_active';
		}
		
		if(document.getElementById('".$label_id[$key]."_element_last".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_last".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."';
			document.getElementById('".$label_id[$key]."_element_last".$id."').className='input_active';
		}
		
	}";
								}
								break;
							}
							
			case "type_phone":{
	
								echo 
	"if(document.getElementById('".$label_id[$key]."_element_first".$id."'))
	{
		if(document.getElementById('".$label_id[$key]."_element_first".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_first".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_first".$id))."';
			document.getElementById('".$label_id[$key]."_element_first".$id."').className='input_active';
		}
		
		if(document.getElementById('".$label_id[$key]."_element_last".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."')
		{	document.getElementById('".$label_id[$key]."_element_last".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_last".$id))."';
			document.getElementById('".$label_id[$key]."_element_last".$id."').className='input_active';
		}
	}";
								
								break;
								}
							
			case "type_address":{	
								if($key>$old_key)
								{
								echo 
	"if(document.getElementById('".$label_id[$key]."_street1".$id."'))
	{
			document.getElementById('".$label_id[$key]."_street1".$id."').value='".addslashes($input_get->getString($label_id[$key]."_street1".$id))."';
			document.getElementById('".$label_id[$key]."_street2".$id."').value='".addslashes($input_get->getString($label_id[$key+1]."_street2".$id))."';
			document.getElementById('".$label_id[$key]."_city".$id."').value='".addslashes($input_get->getString($label_id[$key+2]."_city".$id))."';
			document.getElementById('".$label_id[$key]."_state".$id."').value='".addslashes($input_get->getString($label_id[$key+3]."_state".$id))."';
			document.getElementById('".$label_id[$key]."_postal".$id."').value='".addslashes($input_get->getString($label_id[$key+4]."_postal".$id))."';
			document.getElementById('".$label_id[$key]."_country".$id."').value='".addslashes($input_get->getString($label_id[$key+5]."_country".$id))."';
		
	}";
									$old_key=$key+5;
									}
									break;
		
								}
								
							
							
							
			case "type_checkbox":{
			
											
			$is_other=false;
	
			if( $input_get->getString($label_id[$key]."_allow_other".$id)=="yes")
			{
				$other_element=$input_get->getString($label_id[$key]."_other_input".$id);
				$other_element_id=$input_get->getString($label_id[$key]."_allow_other_num".$id);
				if(isset($other_element))
					$is_other=true;
			}

								echo
	"
	if(document.getElementById('".$label_id[$key]."_other_input".$id."'))
	{
	document.getElementById('".$label_id[$key]."_other_input".$id."').parentNode.removeChild(document.getElementById('".$label_id[$key]."_other_br".$id."'));
	document.getElementById('".$label_id[$key]."_other_input".$id."').parentNode.removeChild(document.getElementById('".$label_id[$key]."_other_input".$id."'));
	}

	for(k=0; k<30; k++)
		if(document.getElementById('".$label_id[$key]."_element".$id."'+k))
			document.getElementById('".$label_id[$key]."_element".$id."'+k).removeAttribute('checked');
		else break;
	";
								for($j=0; $j<100; $j++)
								{
										$element=$input_get->getString($label_id[$key]."_element".$id.$j);
										if(isset($element))
												{
												echo
	"document.getElementById('".$label_id[$key]."_element".$id.$j."').setAttribute('checked', 'checked');
	";
												}
								}
								
	if($is_other)
		echo
	"
		show_other_input('".$label_id[$key]."','".$id."');
		document.getElementById('".$label_id[$key]."_other_input".$id."').value='".$input_get->getString($label_id[$key]."_other_input".$id)."';
	";
	
								
								
								break;
								}
			case "type_radio":{
			
			$is_other=false;
			
			if( $input_get->getString($label_id[$key]."_allow_other".$id)=="yes")
			{
				$other_element=$input_get->getString($label_id[$key]."_other_input".$id);
				if(isset($other_element))
					$is_other=true;
			}
			
			
								echo
	"
	if(document.getElementById('".$label_id[$key]."_other_input".$id."'))
	{
	document.getElementById('".$label_id[$key]."_other_input".$id."').parentNode.removeChild(document.getElementById('".$label_id[$key]."_other_br".$id."'));
	document.getElementById('".$label_id[$key]."_other_input".$id."').parentNode.removeChild(document.getElementById('".$label_id[$key]."_other_input".$id."'));
	}
	
	for(k=0; k<50; k++)
		if(document.getElementById('".$label_id[$key]."_element".$id."'+k))
		{
			document.getElementById('".$label_id[$key]."_element".$id."'+k).removeAttribute('checked');
			if(document.getElementById('".$label_id[$key]."_element".$id."'+k).value=='".addslashes($input_get->getString($label_id[$key]."_element".$id))."')
			{
				document.getElementById('".$label_id[$key]."_element".$id."'+k).setAttribute('checked', 'checked');
								
			}
		}
		else break;
	";
	if($is_other)
								echo
	"
		show_other_input('".$label_id[$key]."','".$id."');
		document.getElementById('".$label_id[$key]."_other_input".$id."').value='".$input_get->getString($label_id[$key]."_other_input".$id)."';
	";
	
						break;
							}
			
			case "type_time":{
								$ss=$input_get->getString($label_id[$key]."_ss".$id);
								if(isset($ss))
								{
									echo 
	"if(document.getElementById('".$label_id[$key]."_hh".$id."'))
	{
		document.getElementById('".$label_id[$key]."_hh".$id."').value='".$input_get->getString($label_id[$key]."_hh".$id)."';
		document.getElementById('".$label_id[$key]."_mm".$id."').value='".$input_get->getString($label_id[$key]."_mm".$id)."';
		document.getElementById('".$label_id[$key]."_ss".$id."').value='".$input_get->getString($label_id[$key]."_ss".$id)."';
	}";
								}
								else
								{
									echo 
	"if(document.getElementById('".$label_id[$key]."_hh".$id."'))
	{
		document.getElementById('".$label_id[$key]."_hh".$id."').value='".$input_get->getString($label_id[$key]."_hh".$id)."';
		document.getElementById('".$label_id[$key]."_mm".$id."').value='".$input_get->getString($label_id[$key]."_mm".$id)."';
	}";
								}
								$am_pm=$input_get->getString($label_id[$key]."_am_pm".$id);
								if(isset($am_pm))
									echo 
	"if(document.getElementById('".$label_id[$key]."_am_pm".$id."'))
		document.getElementById('".$label_id[$key]."_am_pm".$id."').value='".$input_get->getString($label_id[$key]."_am_pm".$id)."';
	";
								break;
							}
							
							
			case "type_date_fields":{
				$date_fields=explode('-',$input_get->getString($label_id[$key]."_element".$id));
									echo 
	"if(document.getElementById('".$label_id[$key]."_day".$id."'))
	{
		document.getElementById('".$label_id[$key]."_day".$id."').value='".$date_fields[0]."';
		document.getElementById('".$label_id[$key]."_month".$id."').value='".$date_fields[1]."';
		document.getElementById('".$label_id[$key]."_year".$id."').value='".$date_fields[2]."';
	}";
							break;
							}
							
			case "type_date":
			case "type_own_select":					
			case "type_country":{
									echo
	"if(document.getElementById('".$label_id[$key]."_element".$id."'))
		document.getElementById('".$label_id[$key]."_element".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element".$id))."';
	";
							break;
							}
							
			default:{
							break;
						}
	
			}
		
	}
}

?>

	form_view_count<?php echo $id ?>=0;
	for(i=1; i<=30; i++)
	{
		if(document.getElementById('<?php echo $id ?>form_view'+i))
		{
			form_view_count<?php echo $id ?>++;
			form_view_max<?php echo $id ?>=i;
			document.getElementById('<?php echo $id ?>form_view'+i).parentNode.removeAttribute('style');
		}
	}
	
	if(form_view_count<?php echo $id ?>>1)
	{
		for(i=1; i<=form_view_max<?php echo $id ?>; i++)
		{
			if(document.getElementById('<?php echo $id ?>form_view'+i))
			{
				first_form_view<?php echo $id ?>=i;
				break;
			}
		}
		
		generate_page_nav(first_form_view<?php echo $id ?>, '<?php echo $id ?>', form_view_count<?php echo $id ?>, form_view_max<?php echo $id ?>);
	}
	
</script>
</form>
<?php if($is_recaptcha) {
		$document->addScriptDeclaration('var RecaptchaOptions = {
theme: "'.$row->recaptcha_theme.'"
};
');

?>

<div id="main_recaptcha" style="display:none;">
<?php
// Get a key from https://www.google.com/recaptcha/admin/create
if($row->public_key)
	$publickey = $row->public_key;
else
	$publickey = '0';
$error = null;
echo recaptcha_get_html($publickey, $error);
?>

</div>
    <script>
	recaptcha_html=document.getElementById('main_recaptcha').innerHTML.replace('Recaptcha.widget = Recaptcha.$("recaptcha_widget_div"); Recaptcha.challenge_callback();',"");
	document.getElementById('main_recaptcha').innerHTML="";
	if(document.getElementById('wd_recaptcha<?php echo $id ?>'))
		document.getElementById('wd_recaptcha<?php echo $id ?>').innerHTML=recaptcha_html;
    </script>



<?php }
?>
	<?php
		$content=ob_get_contents();
		ob_end_clean();
		return $content;


}
}
