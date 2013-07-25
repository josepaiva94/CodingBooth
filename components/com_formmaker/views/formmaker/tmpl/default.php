<?php 
  
 /**
 * @package Form Maker
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access'); 
@session_start();
global $mainframe;
$input_get = JFactory::getApplication()->input;

$id = $input_get->getString('id', 0, 'get', 'int');
$row	= $this->row;
$Itemid = $this->Itemid;
$label_id = $this->label_id;
$label_type = $this->label_type;
$form_theme = $this->form_theme;

$ok	= $this->ok;


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
            $form_currency='$';

			$currency_code=array('USD', 'EUR', 'GBP', 'JPY', 'CAD', 'MXN', 'HKD', 'HUF', 'NOK', 'NZD', 'SGD', 'SEK', 'PLN', 'AUD', 'DKK', 'CHF', 'CZK', 'ILS', 'BRL', 'TWD', 'MYR', 'PHP', 'THB');

			$currency_sign=array('$'  , '€'  , '£'  , '£'  , 'C$', 'Mex$', 'HK$', 'Ft' , 'kr' , 'NZ$', 'S$' , 'kr' , 'zł' , 'A$' , 'kr' , 'CHF' , 'Kč', '₪'  , 'R$' , 'NT$', 'RM' , '₱'  , '฿'  );

			if($row->payment_currency)

				$form_currency=	$currency_sign[array_search($row->payment_currency, $currency_code)];

			echo '<style>'.$form_theme.'
			
			img
{
max-width:none;
}

.mini_label
{
display: inline;
}


			</style>';
			

//			echo '<h3>'.$row->title.'</h3><br />';
?>
<form name="form<?php echo $id; ?>" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" id="form<?php echo $id; ?>" enctype="multipart/form-data" onsubmit="check_required('submit', '<?php echo $id; ?>'); return false;">
<div id="<?php echo $id; ?>pages" class="wdform_page_navigation" show_title="<?php echo $row->show_title; ?>" show_numbers="<?php echo $row->show_numbers; ?>" type="<?php echo $row->pagination; ?>"></div>
<input type="hidden" id="counter<?php echo $id ?>" value="<?php echo $row->counter?>" name="counter<?php echo $id ?>" />
<input type="hidden" id="Itemid<?php echo $id ?>" value="<?php echo $Itemid?>" name="Itemid<?php echo $id ?>" />

<?php
//inch@ petq chi raplace minchev form@ tpi			
			
			$captcha_url='components/com_formmaker/wd_captcha.php?digit=';
			$captcha_rep_url=JURI::root(true).'/components/com_formmaker/wd_captcha.php?r2='.mt_rand(0,1000).'&digit=';
			
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
			"<!--repstart-->Dollars<!--repend-->",
			"<!--repstart-->Cents<!--repend-->",
			"<!--repstart-->&nbsp;$&nbsp;<!--repend-->",
			"<!--repstart-->Quantity<!--repend-->",
			$captcha_url,
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
			JText::_("WDF_DOLLARS"),
			JText::_("WDF_CENTS"),
			'&nbsp;'.$form_currency.'&nbsp;',
			JText::_("WDF_QUANTITY"),
			$captcha_rep_url,
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
WDF_FILE_TYPE_ERROR 	= '<?php echo addslashes(JText::_("WDF_FILE_TYPE_ERROR")); ?>';
WDF_INVALID_EMAIL 		= '<?php echo addslashes(JText::_("WDF_INVALID_EMAIL")); ?>';
REQUEST_URI				= "<?php echo $_SERVER['REQUEST_URI'] ?>";
ReqFieldMsg				='<?php echo addslashes(JText::sprintf('WDF_REQUIRED_FIELD', '`FIELDNAME`')) ?>';  
RangeFieldMsg			='<?php echo JText::sprintf('WDF_RANGE_FIELD', '`FIELDNAME`', '`FROM`','`TO`') ?>';  
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
//	if(!document.getElementById("<?php echo $label_id[$key] ?>_long<?php echo $id ?>"))	
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
				


			case "type_paypal_price":{

	

								echo 

	"if(document.getElementById('".$label_id[$key]."_element_dollars".$id."'))

	{

		if(document.getElementById('".$label_id[$key]."_element_dollars".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_dollars".$id))."')

		{	document.getElementById('".$label_id[$key]."_element_dollars".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_dollars".$id))."';

			document.getElementById('".$label_id[$key]."_element_dollars".$id."').className='input_active';

		}

		

		if(document.getElementById('".$label_id[$key]."_element_cents".$id."').title!='".addslashes($input_get->getString($label_id[$key]."_element_cents".$id))."')

		{	document.getElementById('".$label_id[$key]."_element_cents".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_cents".$id))."';

			document.getElementById('".$label_id[$key]."_element_cents".$id."').className='input_active';

		}

	}";

								

								break;

								}

								

								case "type_paypal_select":{

	

								echo 

	"if(document.getElementById('".$label_id[$key]."_element".$id."')){

		document.getElementById('".$label_id[$key]."_element".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element".$id))."';

	

	if(document.getElementById('".$label_id[$key]."_element_quantity".$id."'))

		document.getElementById('".$label_id[$key]."_element_quantity".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_quantity".$id))."';

		";

		for($j=0; $j<100; $j++)

								{

										$element=JRequest::getVar($label_id[$key]."_property".$id.$j);

										if(isset($element))

												{

												echo

	"document.getElementById('".$label_id[$key]."_property".$id.$j."').value='".addslashes($input_get->getString($label_id[$key]."_property".$id.$j))."';

	";

												}

								}

		echo "

		}";

	

								

								break;

								}

					case "type_paypal_checkbox":{

							

							echo

	"

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

		

								echo 

	"

	if(document.getElementById('".$label_id[$key]."_element_quantity".$id."'))

		document.getElementById('".$label_id[$key]."_element_quantity".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_quantity".$id))."';

		";

		for($j=0; $j<100; $j++)

								{

										$element=$input_get->getString($label_id[$key]."_property".$id.$j);

										if(isset($element))

												{

												echo

	"document.getElementById('".$label_id[$key]."_property".$id.$j."').value='".addslashes($input_get->getString($label_id[$key]."_property".$id.$j))."';

	";

												}

								};	

								break;

								}		

	case "type_paypal_radio":{

							

							echo

	"

	for(k=0; k<50; k++)

		if(document.getElementById('".$label_id[$key]."_element".$id."'+k))

		{

			document.getElementById('".$label_id[$key]."_element".$id."'+k).removeAttribute('checked');

			if(document.getElementById('".$label_id[$key]."_element".$id."'+k).value=='".addslashes($input_get->getString($label_id[$key]."_element".$id))."')

			{

				document.getElementById('".$label_id[$key]."_element".$id."'+k).setAttribute('checked', 'checked');

								

			}

		}

		



	if(document.getElementById('".$label_id[$key]."_element_quantity".$id."'))

		document.getElementById('".$label_id[$key]."_element_quantity".$id."').value='".addslashes($input_get->getString($label_id[$key]."_element_quantity".$id))."';

		";

		for($j=0; $j<100; $j++)

								{

										$element=JRequest::getVar($label_id[$key]."_property".$id.$j);

										if(isset($element))

												{

												echo

	"document.getElementById('".$label_id[$key]."_property".$id.$j."').value='".addslashes($input_get->getString($label_id[$key]."_property".$id.$j))."';

	";

												}

								};

		

	

								

								break;

								}

								

				case "type_paypal_shipping":{

			

								echo

	"

	for(k=0; k<50; k++)

		if(document.getElementById('".$label_id[$key]."_element".$id."'+k))

		{

			document.getElementById('".$label_id[$key]."_element".$id."'+k).removeAttribute('checked');

			if(document.getElementById('".$label_id[$key]."_element".$id."'+k).value=='".addslashes($input_get->getString($label_id[$key]."_element".$id))."')

			{

				document.getElementById('".$label_id[$key]."_element".$id."'+k).setAttribute('checked', 'checked');

								

			}

		}

	

	";

	

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
	{
		document.getElementById('wd_recaptcha<?php echo $id ?>').innerHTML=recaptcha_html;
		Recaptcha.widget = Recaptcha.$("recaptcha_widget_div");
		Recaptcha.challenge_callback();
	}
    </script>



<?php }
?>