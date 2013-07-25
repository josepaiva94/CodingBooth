<?php 
  
 /**
 * @package Form Maker
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');



class HTML_contact
{
    const first_css = ".wdform_table1
{
font-size:14px;
font-weight:normal;
color:#000000;
width:100%;
}

.wdform_tbody1
{
float:left;
}
.wdform_table2
{
padding-right:50px !important;
float:left;
border-spacing: 0px;
border-collapse:separate !important;
}

.time_box
{
border-width:1px;
margin: 0px;
padding: 0px;
text-align:right;
width:30px;
vertical-align:middle
}

.mini_label
{
font-size:10px;
font-family: 'Lucida Grande', Tahoma, Arial, Verdana, sans-serif;
display: inline;
}

.ch_rad_label
{
display:inline;
margin-left:5px;
margin-right:15px;
float:none;
}

.label
{
border:none;
}


.td_am_pm_select
{
padding-left:5;
}

.am_pm_select
{
height: 16px;
margin:0;
padding:0
}

.input_deactive
{
color:#999999;
font-style:italic;
border-width:1px;
margin: 0px;
padding: 0px
}

.input_active
{
color:#000000;
font-style:normal;
border-width:1px;
margin: 0px;
padding: 0px
}

.required
{
border:none;
color:red
}

.captcha_img
{
border-width:0px;
margin: 0px;
padding: 0px;
cursor:pointer;


}

.captcha_refresh
{
width:30px;
height:30px;
border-width:0px;
margin: 0px;
padding: 0px;
vertical-align:middle;
cursor:pointer;
background-image: url(components/com_formmaker/images/refresh_black.png);
}

.captcha_input
{
height:20px;
border-width:1px;
margin: 0px;
padding: 0px;
vertical-align:middle;
}

.file_upload
{
border-width:1px;
margin: 0px;
padding: 0px
}    

.page_deactive
{
border:1px solid black;
padding:4px 7px 4px 7px;
margin:4px;
cursor:pointer;
background-color:#DBDBDB;
}

.page_active
{
border:1px solid black;
padding:4px 7px 4px 7px;
margin:4px;
cursor:pointer;
background-color:#878787;
}

.page_percentage_active
{
padding:0px;
margin:0px;
border-spacing: 0px;
height:30px;
line-height:30px;
background-color:yellow;
border-radius:30px;
font-size:15px;
float:left;
text-align: right !important; 
}


.page_percentage_deactive
{
height:30px;
line-height:30px;
padding:5px;
border:1px solid black;
width:100%;
background-color:white;
border-radius:30px;
text-align: left !important; 
}

.page_numbers
{
font-size:11px;
}

.phone_area_code
{
width:50px;
}

.phone_number
{
width:100px;
}";

function form_options(&$row, &$themes){

		JRequest::setVar( 'hidemainmenu', 1 );
		
		$is_editor=false;
		
		$plugin =& JPluginHelper::getPlugin('editors', 'tinymce');
		if (isset($plugin->type))
		{ 
			$editor	=& JFactory::getEditor('tinymce');
			$is_editor=true;
		}
		
		$editor	=& JFactory::getEditor('tinymce');

		$value="";

		$article =& JTable::getInstance('content');
		if ($value) {
			$article->load($value);
		} else {
			$article->title = JText::_('Select an Article');
		}
		
			$label_id= array();		
			$label_label= array();		
			$label_type= array();			
			$label_all	= explode('#****#',$row->label_order_current);		
			$label_all 	= array_slice($label_all,0, count($label_all)-1);   	
			
		foreach($label_all as $key => $label_each) 		
		{			
			$label_id_each=explode('#**id**#',$label_each);			
			array_push($label_id, $label_id_each[0]);					
		
		$label_order_each=explode('#**label**#', $label_id_each[1]);				
			array_push($label_label, $label_order_each[0]);		
			array_push($label_type, $label_order_each[1]);		
		}			
		
		?>

<script language="javascript" type="text/javascript">
Joomla.submitbutton= function (pressbutton)
{
	var form = document.adminForm;
	if (pressbutton == 'cancel') 
	{
		submitform( pressbutton );
		return;
	}
	
	if(form.mail.value!='')
	{
		subMailArr=form.mail.value.split(',');
		emailListValid=true;
		for(subMailIt=0; subMailIt<subMailArr.length; subMailIt++)
		{
		trimmedMail = subMailArr[subMailIt].replace(/^\s+|\s+$/g, '') ;
		if (trimmedMail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1)
		{
					alert( "This is not a list of valid email addresses." );	
					emailListValid=false;
					break;
		}
		}
		if(!emailListValid)	
		return;
	}	

	submitform( pressbutton );
}

function check_isnum(e)
{
	
   	var chCode1 = e.which || e.keyCode;
    	if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57))
        return false;
	return true;
}

function jSelectArticle(id, title, object) {
			document.getElementById('article_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
			}
			
function remove_article()
{
	document.getElementById('id_name').value="Select an Article";
	document.getElementById('article_id').value="";
}

function set_type(type)
{
	switch(type)
	{
		case 'article':
			document.getElementById('article').removeAttribute('style');
			document.getElementById('custom').setAttribute('style','display:none');
			document.getElementById('url').setAttribute('style','display:none');
			document.getElementById('none').setAttribute('style','display:none');
			break;
			
		case 'custom':
			document.getElementById('article').setAttribute('style','display:none');
			document.getElementById('custom').removeAttribute('style');
			document.getElementById('url').setAttribute('style','display:none');
			document.getElementById('none').setAttribute('style','display:none');
			break;
			
		case 'url':
			document.getElementById('article').setAttribute('style','display:none');
			document.getElementById('custom').setAttribute('style','display:none');
			document.getElementById('url').removeAttribute('style');
			document.getElementById('none').setAttribute('style','display:none');
			break;
			
		case 'none':
			document.getElementById('article').setAttribute('style','display:none');
			document.getElementById('custom').setAttribute('style','display:none');
			document.getElementById('url').setAttribute('style','display:none');
			document.getElementById('none').removeAttribute('style');
			break;
	}
}

function insertAtCursorform(myField, myValue) {  
	if(myField.style.display=="none")
	{

		tinyMCE.execCommand('mceInsertContent',false,"%"+myValue+"%");
		return;
	}

	
	   if (document.selection) {      
	   myField.focus();      
	   sel = document.selection.createRange();    
	   sel.text = myValue;    
	   }    
   else
		if (myField.selectionStart || myField.selectionStart == '0') {     
		   var startPos = myField.selectionStart;       
		   var endPos = myField.selectionEnd;      
		   myField.value = myField.value.substring(0, startPos)           
		   +  "%"+myValue+"%"        
		   + myField.value.substring(endPos, myField.value.length);   
		} 
   else {     
   myField.value += "%"+myValue+"%";    
   }


   }

   
   
function set_preview()
{
	appWidth			=parseInt(document.body.offsetWidth);
	appHeight			=parseInt(document.body.offsetHeight);

document.getElementById('modalbutton').href='index.php?option=com_formmaker&task=preview&format=raw&theme='+document.getElementById('theme').value;
document.getElementById('modalbutton').setAttribute("rel","{handler: 'iframe', size: {x:"+(appWidth-100)+", y: "+(appHeight-100)+"}}");

}

gen="<?php echo $row->counter; ?>";
form_view_max=20;
</script>
<style>
.borderer
{
border-radius:5px;
padding-left:5px;
background-color:#F0F0F0;
height:19px;
width:153px;
}

fieldset.adminform {
border-radius: 7px;
}

label
{
display:inline;
}
</style>

<form action="index.php" method="post" name="adminForm">

	<div class="row-fluid">
		<div class="span10 form-horizontal">
		
		
		
			<fieldset>
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general_op" data-toggle="tab">General Options</a></li>
					<li><a href="#actions_op" data-toggle="tab">Actions after submission</a></li>
					
					<li><a href="#javascript_op" data-toggle="tab">Javascript</a></li>
					<li><a href="#email_op" data-toggle="tab">Custom text in email</a></li>
				</ul>
			</fieldset>
			
			
			
			
			<div class="tab-content">
				<div class="tab-pane active" id="general_op">
						<table class="admintable"  style="float:left">
							<tr valign="top">
								<td class="key">
									<label> <?php echo JText::_( 'Email to send submissions to' ); ?>: </label>
								</td>
								<td>
									<input type="text" id="mail" name="mail" value="<?php echo $row->mail ?>" style="width:235px;" />
								</td>
							</tr>
							<tr valign="top">
								<td class="key">
									<label> <?php echo JText::_( 'Theme' ); ?>: </label>
								</td>
								<td>
									<select id="theme" name="theme" style="width:250px; " onChange="set_preview()" >
									<?php 
									foreach($themes as $theme) 
									{
										if($theme->id==$row->theme)
										{
											echo '<option value="'.$theme->id.'" selected>'.$theme->title.'</option>';
										}
										else
											echo '<option value="'.$theme->id.'">'.$theme->title.'</option>';
									}
									?>
									</select> 
								
								</td>
							</tr>
						</table>
						<style>
						div.wd_preview span{ float: none; width: 32px; height: 32px; margin: 0 auto; display: block; }
						div.wd_preview a {display: block; float: left;	white-space: nowrap;border: 1px solid #fbfbfb;	padding: 1px 5px;cursor: pointer; text-decoration:none}

						</style>
						
						
						
						
					<div class="button wd_preview" id="toolbar-popup-popup">
					<a class="modal" id="modalbutton" href="index.php?option=com_formmaker&amp;task=preview&amp;tmpl=component&amp;theme=<?php echo $row->theme ?>" rel="{handler: 'iframe', size: {x:1000, y: 520}}">
					<span class="icon-32-preview" title="Preview" >
					</span>
					Preview
					</a>
					</div>

				</div>
				
				<div class="tab-pane" id="actions_op">
					<table class="admintable">

						<tr valign="top">
							<td class="key">
								<label for="submissioni text"> <?php echo JText::_( 'Action type' ); ?>: </label>
							</td>
							<td>
							<input type="radio" name="submit_text_type" onclick="set_type('none')"		value="1" <?php if($row->submit_text_type!=2 and $row->submit_text_type!=3 ) echo "checked" ?> /> Stay on form<br/>
							<input type="radio" name="submit_text_type" onclick="set_type('article')"  	value="2" <?php if($row->submit_text_type==2 ) echo "checked" ?> /> Article<br/>
							<input type="radio" name="submit_text_type" onclick="set_type('custom')" 	value="3" <?php if($row->submit_text_type==3 ) echo "checked" ?> /> Custom text<br/>
							<input type="radio" name="submit_text_type" onclick="set_type('url')" 		value="4" <?php if($row->submit_text_type==4 ) echo "checked" ?> /> URL
							</td>
						</tr>
						<tr  id="none" <?php if($row->submit_text_type==2 or $row->submit_text_type==3 or $row->submit_text_type==4 ) echo 'style="display:none"' ?> >
							<td class="key">
								<label for="submissioni text"> <?php echo JText::_( 'Stay on form' ); ?>: </label>
							</td>
							<td >
								<i class="icon-checkin "></i>
							</td>
					   </tr>
						<tr id="article" <?php if($row->submit_text_type!=2) echo 'style="display:none"' ?>   >
							<td class="key">
								<label for="submissioni text"> <?php echo JText::_( 'Article' ); ?>: </label>
							</td>
			<td >
		<?php 

$name="id";
$value=$row->article_id;
$control_name="urlparams";

		$db		=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$fieldName	= $control_name.'['.$name.']';
		$article =& JTable::getInstance('content');
		if ($value) {
			$article->load($value);
		} else {
			$article->title = JText::_('Select an Article');
		}

		$js = "	function jSelectArticle_".$name."(id, title, object) {
			document.getElementById('article_id').value = id;
			document.getElementById('".$name."_name').value = title;
			SqueezeBox.close();
		}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle_'.$name;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="background-color:white; height:19px"><a class="modal" title="'.JText::_('Select an Article').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 750, y: 500}}"><input style="background:none; width:151px; height:17px; border:none; font-size:11px" type="text" id="'.$name.'_name" value="'.htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8').'"  readonly="readonly" /></a></div>';
		$html .= "\n".'</div><input type="hidden" id="article_id" name="article_id" value="'.(int)$value.'" />';

		echo $html;

?>
			<span onclick="remove_article()" style="color:#000000; cursor:pointer; padding-left:5px;"><i>Remove article</i></span>			
			</td>
						</tr>
						<tr  <?php if($row->submit_text_type!=3 ) echo 'style="display:none"' ?>  id="custom">
						   <td class="key">
								<label for="submissioni text"> <?php echo JText::_( 'Text' ); ?>: </label>
						   </td>
						   <td >
						   
				<?php if($is_editor) echo $editor->display('submit_text',$row->submit_text,'50%','350','40','6');
				else
				{
				?>
				<textarea name="submit_text" id="submit_text" cols="40" rows="6" style="width: 450px; height: 350px; " class="mce_editable" aria-hidden="true"><?php echo $row->submit_text ?></textarea>
				<?php

				}
				 ?>		   		   
							</td>
						</tr>
						<tr  <?php if($row->submit_text_type!=4 ) echo 'style="display:none"' ?>  id="url">
						   <td class="key">
								<label for="submissioni text"> <?php echo JText::_( 'URL' ); ?>: </label>
						   </td>
						   <td >
							   <input type="text" id="url" name="url" style="width:300px" value="<?php echo $row->url ?>" />
							</td>
						</tr>
				   

					</table>
				</div>

		

				<div class="tab-pane" id="javascript_op">
					<table class="admintable">

						<tr valign="top">

							<td  class="key">

								<label for="javascript"> <?php echo JText::_( 'Javascript' ); ?> </label>

							</td>
							<td >
								<textarea style="margin: 0px; width:600px; height:500px"  name="javascript" id="javascript" ><?php echo $row->javascript; ?></textarea>
							</td>
						</tr>
					</table>
				</div>

				<div class="tab-pane" id="email_op">
					<table class="admintable">
					
						<tr>
							<td class="key" valign="top">
								<label > <?php echo JText::_( 'For Administrator' ); ?>: </label>
							</td>

							<td>
							<div style="margin-bottom:5px">
							<?php 
							for($i=0; $i<count($label_label); $i++)			
							{ 			
								if($label_type[$i]=="type_submit_reset" || $label_type[$i]=="type_editor" || $label_type[$i]=="type_map" || $label_type[$i]=="type_mark_map" || $label_type[$i]=="type_captcha"|| $label_type[$i]=="type_recaptcha"|| $label_type[$i]=="type_button" )			
								continue;		
								
								$param = "'".htmlspecialchars(addslashes($label_label[$i]))."'";					
							
								$choise = 'document.getElementById(\'script_mail\')';		
								echo '<input type="button" value="'.htmlspecialchars(addslashes($label_label[$i])).'" onClick="insertAtCursorform('.$choise.','.$param.')" /> ';	
							}	

							
								$choise = 'document.getElementById(\'script_mail\')';			
								echo '<input style="margin:3px" type="button" value="All fields list" onClick="insertAtCursorform('.$choise.',\'all\')" /> ';			
							?>

							  
						</div>


				<?php if($is_editor) echo $editor->display('script_mail',$row->script_mail,'50%','350','40','6');
				else
				{
				?>
				<textarea name="script_mail" id="script_mail" cols="40" rows="6" style="width: 450px; height: 350px; " class="mce_editable" aria-hidden="true"><?php echo $row->script_mail ?></textarea>
				<?php

				}
				 ?>		   		   

							</td>

						</tr>
						<tr>
							<td  valign="top" height="30">
							</td>
							<td  valign="top">
							</td>
						</tr>

						<tr>
							<td class="key" valign="top">
								<label > <?php echo JText::_( 'For User' ); ?>: </label>
							</td>

							<td>
							<div style="margin-bottom:5px">
							<?php 
							for($i=0; $i<count($label_label); $i++)			
							{ 			
							if($label_type[$i]=="type_submit_reset" || $label_type[$i]=="type_editor" || $label_type[$i]=="type_map" || $label_type[$i]=="type_mark_map" || $label_type[$i]=="type_captcha"|| $label_type[$i]=="type_recaptcha"|| $label_type[$i]=="type_button" )			
							continue;		
								
								$param = "'".htmlspecialchars(addslashes($label_label[$i]))."'";					
							
							$choise = 'document.getElementById(\'script_mail_user\')';		
							echo '<input type="button" value="'.htmlspecialchars(addslashes($label_label[$i])).'" onClick="insertAtCursorform('.$choise.','.$param.')" /> ';	
							
							}	

							
							
								$choise = 'document.getElementById(\'script_mail_user\')';			
								echo '<input style="margin:3px" type="button" value="All fields list" onClick="insertAtCursorform('.$choise.',\'all\')" /> ';					
							?>

							  
						</div>

				<?php if($is_editor) echo $editor->display('script_mail_user',$row->script_mail_user,'50%','350','40','6');
				else
				{
				?>
				<textarea name="script_mail_user" id="script_mail_user" cols="40" rows="6" style="width: 450px; height: 350px; " class="mce_editable" aria-hidden="true"><?php echo $row->script_mail_user ?></textarea>
				<?php

				}
				 ?>		   		   

							</td>

						</tr>

					
					
					</table>

				</div>

			</div>
		</div>
	</div>

    <input type="hidden" name="option" value="com_formmaker" />
    <input type="hidden" name="id" value="<?php echo $row->id?>" />
    <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="task" value="" />
</form>
	

<div style="display:none" id="pages" show_title="<?php echo $row->show_title; ?>" show_numbers="<?php echo $row->show_numbers; ?>" type="<?php echo $row->pagination; ?>"></div>	
<div id="take" style="display:none">
<?php echo $row->form?>
</div>	
	
	<script language="javascript" type="text/javascript">
		document.getElementById('payment_currency').value="<?php echo $row->payment_currency; ?>";
	</script>

<?php		

       }

function paypal_info($row){
if(!isset($row->ipn))
{
echo "<div style='width:100%; text-align:center; height: 100%; vertical-align:middle'><h1 style='top: 44%;position: absolute;left:38%; color:#000'>No information yet<p></h1>";
return;
}
?>
<h2>Payment Info</h2>
<table class="admintable">
	<tr>
		<td class="key">Currency</td>
		<td><?php echo $row->currency; ?></td>
	</tr>
	<tr>
		<td class="key">Last modified</td>
		<td><?php echo $row->ord_last_modified; ?></td>
	</tr>
	<tr>
		<td class="key">Status</td>
		<td><?php echo $row->status; ?></td>
	</tr>
	<tr>
		<td class="key">Full name</td>
		<td><?php echo $row->full_name; ?></td>
	</tr>
	<tr>
		<td class="key">Email</td>
		<td><?php echo $row->email; ?></td>
	</tr>
	<tr>
		<td class="key">Phone</td>
		<td><?php echo $row->phone; ?></td>
	</tr>
	<tr>
		<td class="key">Mobile phone</td>
		<td><?php echo $row->mobile_phone; ?></td>
	</tr>
	<tr>
		<td class="key">Fax</td>
		<td><?php echo $row->fax; ?></td>
	</tr>
	<tr>
		<td class="key">Address</td>
		<td><?php echo $row->address; ?></td>
	</tr>
	<tr>
		<td class="key">Paypal info</td>
		<td><?php echo $row->paypal_info; ?></td>
	</tr>	
	<tr>
		<td class="key">IPN</td>
		<td><?php echo $row->ipn; ?></td>
	</tr>
	<tr>
		<td class="key">Tax</td>
		<td><?php echo $row->tax; ?>%</td>
	</tr>
	<tr>
		<td class="key">Shipping</td>
		<td><?php echo $row->shipping; ?></td>
	</tr>
	<tr>
		<td class="key">Read</td>
		<td><?php echo $row->read; ?></td>
	</tr>
	<tr>
		<td class="key">Total</td>
		<td><b><?php echo $row->total; ?></b></td>
	</tr>
</table>


<?php

}


function show_map($long,$lat){

		$document =& JFactory::getDocument();
 		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';

		$document->addScript($cmpnt_js_path.'/if_gmap.js');
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
?>
<table style="margin:0px; padding:0px">
<tr><td><b>Address:</b></td><td><input type="text" id="addrval0" style="border:0px; background:none" size="100" readonly /> </td></tr>
<tr><td><b>Longitude:</b></td> <td><input type="text" id="longval0" style="border:0px; background:none" size="100" readonly /> </td></tr>
<tr><td><b>Latitude:</b></td><td><input type="text" id="latval0" style="border:0px; background:none" size="100" readonly /> </td></tr>
</table>
		
<div id="0_elementform_id_temp" long="<?php echo $long ?>" center_x="<?php echo $long ?>" center_y="<?php echo $lat ?>" lat="<?php echo $lat ?>" zoom="8" info="" style="width:600px; height:500px; "></div>

<script>
		if_gmap_init("0");
		add_marker_on_map(0, 0, "<?php echo $long ?>", "<?php echo $lat ?>", '');


</script>

<?php		

}


function country_list($id){

		$document		=& JFactory::getDocument();
		
		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';

		$document->addScript($cmpnt_js_path.'/jquery-1.7.1.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.core.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.widget.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.mouse.js');
    	$document->addScript($cmpnt_js_path.'/jquery.ui.slider.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.sortable.js');
		$document->addStyleSheet($cmpnt_js_path.'/jquery-ui.css');
		$document->addStyleSheet($cmpnt_js_path.'/parseTheme.css');

?>
<span style=" position: absolute;right: 29px;" >
<img alt="ADD" title="add" style="cursor:pointer; vertical-align:middle; margin:5px; " src="components/com_formmaker/images/save.png" onclick="save_list()">
<img alt="CANCEL" title="cancel" style=" cursor:pointer; vertical-align:middle; margin:5px; " src="components/com_formmaker/images/cancel_but.png" onclick="window.parent.SqueezeBox.close();">
</span>
<button onclick="select_all()">Select all</button>
<button onclick="remove_all()">Remove all</button>
<ul id="countries_list" style="list-style:none; padding:0px">
</ul>

<script>


selec_coutries=[];

coutries=["","Afghanistan","Albania",	"Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepa","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"];	

select_=window.parent.document.getElementById('<?php echo $id ?>_elementform_id_temp');
n=select_.childNodes.length;
for(i=0; i<n; i++)
{

	selec_coutries.push(select_.childNodes[i].value);
	var ch = document.createElement('input');
		ch.setAttribute("type","checkbox");
		ch.setAttribute("checked","checked");
		ch.value=select_.childNodes[i].value;
		ch.id=i+"ch";
		//ch.setAttribute("id",i);
	
	
	var p = document.createElement('span');
	    p.style.cssText ="color:#000000; font-size: 13px; cursor:move";
		p.innerHTML=select_.childNodes[i].value;

	var li = document.createElement('li');
	    li.style.cssText ="margin:3px; vertical-align:middle";
		li.id=i;
		
	li.appendChild(ch);
	li.appendChild(p);
	
	document.getElementById('countries_list').appendChild(li);
}
cur=i;
m=coutries.length;
for(i=0; i<m; i++)
{
	isin=isValueInArray(selec_coutries, coutries[i]);
	
	if(!isin)
	{
		var ch = document.createElement('input');
			ch.setAttribute("type","checkbox");
			ch.value=coutries[i];
			ch.id=cur+"ch";
		
		
		var p = document.createElement('span');
			p.style.cssText ="color:#000000; font-size: 13px; cursor:move";
			p.innerHTML=coutries[i];

		var li = document.createElement('li');
			li.style.cssText ="margin:3px; vertical-align:middle";
			li.id=cur;
			
		li.appendChild(ch);
		li.appendChild(p);
		
		document.getElementById('countries_list').appendChild(li);
		cur++;
	}
}




	$( "#countries_list" ).sortable();
	$( "#countries_list" ).disableSelection();

function isValueInArray(arr, val) {
	inArray = false;
	for (x = 0; x < arr.length; x++)
		if (val == arr[x])
			inArray = true;
	return inArray;
}
function save_list()
{
select_.innerHTML=""
	ul=document.getElementById('countries_list');
	n=ul.childNodes.length;
	for(i=0; i<n; i++)
	{
		if(ul.childNodes[i].tagName=="LI")
		{
			id=ul.childNodes[i].id;
			if(document.getElementById(id+'ch').checked)
			{
				var option_ = document.createElement('option');
					option_.setAttribute("value", document.getElementById(id+'ch').value);
					option_.innerHTML=document.getElementById(id+'ch').value;

				select_.appendChild(option_);
			}
				
		}
		
		
	}
	window.parent.SqueezeBox.close();


}

function select_all()
{
	for(i=0; i<194; i++)
	{
		document.getElementById(i+'ch').checked=true;;	
	}
}

function remove_all()
{
	for(i=0; i<194; i++)
	{
		document.getElementById(i+'ch').checked=false;;	
	}
}
</script>




<?php

}


function product_option($id, $property_id){

		$document		=& JFactory::getDocument();
		
		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';

		$document->addScript($cmpnt_js_path.'/jquery-1.7.1.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.core.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.widget.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.mouse.js');
    	$document->addScript($cmpnt_js_path.'/jquery.ui.slider.js');
		$document->addScript($cmpnt_js_path.'/jquery.ui.sortable.js');
		$document->addStyleSheet($cmpnt_js_path.'/jquery-ui.css');
		$document->addStyleSheet($cmpnt_js_path.'/parseTheme.css');
		JHTML::_('behavior.modal');

?>
<style>
label{
display:inline
}
</style>
<span style=" position:fixed; right:10px" >
<img alt="ADD" title="add" style="cursor:pointer; vertical-align:middle; margin:5px; " src="components/com_formmaker/images/save.png" onclick="save_options()">
<img alt="CANCEL" title="cancel" style=" cursor:pointer; vertical-align:middle; margin:5px; " src="components/com_formmaker/images/cancel_but.png" onclick="window.parent.SqueezeBox.close();">
</span>

<div style="margin-left:10px">
	<br>
	<fieldset>
		<legend>
			<label style="color: rgb(0, 174, 239); font-weight: bold; font-size: 13px;">Properties</label>
		</legend>
		<br>
		<div style="margin-left:10px">
		<label style="color: rgb(0, 174, 239); font-weight: bold; font-size: 13px; margin-right:20px">Type </label>
		<select id="option_type" style="width: 200px; border-width: 1px;" onchange="type_add_predefined(this.value)">
			<option value="Custom" selected="selected">Custom</option>
			<option value="Color">Color</option>
			<option value="T-Shirt Size">T-Shirt Size</option>
			<option value="Print Size">Print Size</option>
			<option value="Screen Resolution">Screen Resolution</option>
			<option value="Shoe Size">Shoe Size</option>
		</select>
		<br>

		<label style="color: rgb(0, 174, 239); font-weight: bold; font-size: 13px; margin-right:23px">Title </label>
		<input type="text" style="width:200px"  id="option_name" />
		<br>
		<br>
		<label style="color: rgb(0, 174, 239); font-weight: bold; font-size: 13px;">Properties</label> &nbsp;
		<img id="el_choices_add" src="components/com_formmaker/images/add.png" style="cursor: pointer;" title="add" onclick="add_choise_option()">
		<br>

		<div style="margin-left:0px" id="options" ></div>

		</div>
	</fieldset>



</div>


<script>
var j=0;
function save_options()
{
	
	if( document.getElementById('option_name').value=='')
	{
		alert('The option must have a title')
		return;
	}
<?php

if(!isset($property_id))
{
?>

	
		for(i=30; i>=0; i--)
		{
			if(window.parent.document.getElementById(<?php echo $id ?>+"_propertyform_id_temp"+i))
			{
				i=i+1;
				select_ = document.createElement('select');
				select_.setAttribute("id", <?php echo $id ?>+"_propertyform_id_temp"+i);
				select_.setAttribute("name", <?php echo $id ?>+"_propertyform_id_temp"+i);
				select_.style.cssText = "width:auto; margin:2px 0px";
				break;	
			}
		}
		
		if(i==-1)
		{
			i=0;
			select_ = document.createElement('select');
			select_.setAttribute("id", <?php echo $id ?>+"_propertyform_id_temp"+i);
			select_.setAttribute("name", <?php echo $id ?>+"_propertyform_id_temp"+i);
			select_.style.cssText = "width:auto; margin:2px 0px";;
		}
		
		
		for(k=0; k<=50; k++)
		{
			if(document.getElementById('el_option'+k))
			{
				var option = document.createElement('option');
					option.setAttribute("id","<?php echo $id ?>_"+i+"_option"+k);
					option.setAttribute("value", document.getElementById('el_option'+k).value);
					option.innerHTML =  document.getElementById('el_option'+k).value;
					select_.appendChild(option);	
			}
		}
	

	
	var select_label = document.createElement('label');
			select_label.innerHTML =  document.getElementById('option_name').value;
			select_label.style.cssText = "margin-right:5px";		
			select_label.setAttribute("class", 'mini_label');
			select_label.setAttribute("id", '<?php echo $id ?>_property_label_form_id_temp'+i);

		var span_ = document.createElement('span');
			span_.style.cssText = "margin-right:15px";
			span_.setAttribute("id", '<?php echo $id ?>_property_'+i);
			

		
		div_=window.parent.document.getElementById("<?php echo $id ?>_divform_id_temp");
		span_.appendChild(select_label);
		span_.appendChild(select_);
		div_.appendChild(span_);
		
		var li_ = document.createElement('li');
			li_.setAttribute("id", 'property_li_'+i);

		var li_label = document.createElement('label');
			li_label.innerHTML=document.getElementById('option_name').value;
			li_label.setAttribute("id", 'label_property_'+i);
			li_label.style.cssText ="font-weight:bold; font-size: 13px; display:inline";
			
		var li_edit = document.createElement('a');	
			li_edit.setAttribute("rel", "{handler: 'iframe', size: {x: 650, y: 375}}"	);
			li_edit.setAttribute("href","index.php?option=com_formmaker&task=product_option&field_id=<?php echo $id ?>&property_id="+i+"&tmpl=component");
			li_edit.setAttribute("class","modal");
			li_edit.style.cssText = "width:14px; height:14px;  display:inline-block; background-image:url(components/com_formmaker/images/edit.png);   margin-left:13px;";

		var li_edit_img = document.createElement('img');
			li_edit_img.setAttribute("src", 'components/com_formmaker/images/edit.png');
			li_edit_img.style.cssText = "margin-left:13px;";

		//li_edit.appendChild(li_edit_img);
			
		var li_x = document.createElement('img');
			li_x.setAttribute("src", 'components/com_formmaker/images/delete.png');
			li_x.setAttribute("onClick", 'remove_property(<?php echo $id ?>,'+i+')');
			li_x.style.cssText = "margin-left:3px; margin-bottom:6px; cursor:pointer";
			
			
		ul_=window.parent.document.getElementById("option_ul");
		
		li_.appendChild(li_label);
		li_.appendChild(li_edit);
		li_.appendChild(li_x);
		ul_.appendChild(li_);
		window.parent.SqueezeBox.assign(li_edit, {
					parse: 'rel'
				});
	
<?php
}	
else
	
{

?>
	
		i=<?php echo $property_id ?>;
		var select_ = window.parent.document.getElementById('<?php echo $id ?>_propertyform_id_temp<?php echo $property_id ?>');	
		select_.innerHTML="";
		for(k=0; k<=j; k++)
		{
			if(document.getElementById('el_option'+k))
			{
				var option = document.createElement('option');
					option.setAttribute("id","<?php echo $id ?>_"+i+"_option"+k);
					option.setAttribute("value", document.getElementById('el_option'+k).value);
					option.innerHTML =  document.getElementById('el_option'+k).value;
					select_.appendChild(option);	
			}
		}
		
		

		var select_label = document.createElement('label');
			select_label.innerHTML =  document.getElementById('option_name').value;
			select_label.style.cssText = "margin-right:5px";
			select_label.setAttribute("class", 'mini_label');
			select_label.setAttribute("id", '<?php echo $id ?>_property_label_form_id_temp'+i);

		var span_ = window.parent.document.getElementById('<?php echo $id ?>_property_<?php echo $property_id ?>');	
			span_.innerHTML='';
		
		span_.appendChild(select_label);
		span_.appendChild(select_);
		window.parent.document.getElementById('label_property_<?php echo $property_id ?>').innerHTML=document.getElementById('option_name').value;

	
<?php
}	

?>

	window.parent.SqueezeBox.close();
}


function type_add_predefined( type )
{
	document.getElementById('options').innerHTML='';
	
	switch(type)
	{
		case 'Custom': 
		{
			w_choices=[];
			break;	
		}

		case 'Color': 
		{
			w_choices=["Red", "Blue", "Green", "Yellow", "Black"];
			break;	
		}

		case 'T-Shirt Size': 
		{
			w_choices=["XS","S","M","L","XL","XXL","XXXL"];
			break;	
		}

		case 'Print Size': 
		{
			w_choices=["A4","A3","A2","A1"];
			break;	
		}

		case 'Screen Resolution': 
		{
			w_choices=["1024x768","1152x864","1280x768","1280x800","1280x960","1280x1024","1366x768","1440x900","1600x1200","1680x1050","1920x1080","1920x1200"];
			break;	
		}

		case 'Shoe Size': 
		{
			w_choices=["8","8.5","9","9.5","10","10.5","11","11.5","12","13","14"];
			break;	
		}

	}
	type_add_options( w_choices);

}



function delete_options()
{
document.getElementById('options').innerHTML='';
}

function type_add_options( w_choices){
	
	i=0;
	edit_main_td3=document.getElementById('options');
	var br = document.createElement('br');
	edit_main_td3.appendChild(br);

	n=w_choices.length;
	for(j=0; j<n; j++)
	{	
		var br = document.createElement('br');
		br.setAttribute("id", "br"+j);
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_option"+j);
			el_choices.setAttribute("type", "text");
			el_choices.setAttribute("value", w_choices[j]);
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
	//		el_choices.setAttribute("onKeyUp", "change_label('"+i+"_option"+j+"', this.value)");
	
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_option"+j+"_remove");
			el_choices_remove.setAttribute("src", 'components/com_formmaker/images/delete.png');
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_option("+j+","+i+")");
			
			
		edit_main_td3.appendChild(br);
		edit_main_td3.appendChild(el_choices);
		edit_main_td3.appendChild(el_choices_remove);
	
	}

}



function add_choise_option()
{
		num=0;
		j++;	
		
		var choices_td= document.getElementById('options');
		var br = document.createElement('br');
		br.setAttribute("id", "br"+j);
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_option"+j);
			el_choices.setAttribute("type", "text");
			el_choices.setAttribute("value", "");
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
		//	el_choices.setAttribute("onKeyUp", "change_label('"+num+"_option"+j+"', this.value)");
			
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_option"+j+"_remove");
			el_choices_remove.setAttribute("src", 'components/com_formmaker/images/delete.png');
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_option('"+j+"','"+num+"')");
			
	    choices_td.appendChild(br);
	    choices_td.appendChild(el_choices);
	    choices_td.appendChild(el_choices_remove);

}

function remove_option(id, num)
{
		
		var choices_td= document.getElementById('options');
		var el_choices = document.getElementById('el_option'+id);
		var el_choices_remove = document.getElementById('el_option'+id+'_remove');
		var br = document.getElementById('br'+id);
		
		choices_td.removeChild(el_choices);
		choices_td.removeChild(el_choices_remove);
		choices_td.removeChild(br);
}

<?php
if(isset($property_id))
{
?>

	label_	=		window.parent.document.getElementById('<?php echo $id ?>_property_label_form_id_temp<?php echo $property_id ?>').innerHTML;
	select_	=		window.parent.document.getElementById('<?php echo $id ?>_propertyform_id_temp<?php echo $property_id ?>');
	n = select_.childNodes.length;
	delete_options();
 	w_choices=[ ];

	document.getElementById('option_name').value=label_;
	
	
	for(k=0; k<n; k++)
	{
	w_choices.push(select_.childNodes[k].value);
	}
	type_add_options( w_choices);

<?php
}

?>


</script>
<?php

}




function preview_formmaker($css){
 /**
 * @package SpiderFC
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
		JHTML::_('behavior.tooltip');	
		JHTML::_('behavior.calendar');
		$document =& JFactory::getDocument();
 		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';

		$document->addScript($cmpnt_js_path.'/if_gmap.js');
		$document->addScript($cmpnt_js_path.'/main.js');
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
		
		//$document->addStyleSheet(JURI::root(true).'/administrator/components/com_formmaker/css/style.css');
		
		$id='form_id_temp';
?>
<script src="<?php echo $cmpnt_js_path.'/if_gmap.js'; ?>" ></script>
<script src="<?php echo $cmpnt_js_path.'/main.js'; ?>" ></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" ></script>

<style>
html
{
height:90%;
}
<?php echo str_replace('[SITE_ROOT]', JURI::root(true), $css); ?>
</style>
<div id="form_id_temppages" class="wdform_page_navigation" show_title="" show_numbers="" type=""></div>

  <form id="form_preview"></form>
<input type="hidden" id="counter<?php echo $id ?>" value="" name="counter<?php echo $id ?>" />

<script>
	JURI_ROOT				='<?php echo JURI::root(true) ?>';  
	
	document.getElementById('form_preview').innerHTML = window.parent.document.getElementById('take').innerHTML;
	document.getElementById('form_id_temppages').setAttribute('show_title', window.parent.document.getElementById('pages').getAttribute('show_title'));
	document.getElementById('form_id_temppages').setAttribute('show_numbers', window.parent.document.getElementById('pages').getAttribute('show_numbers'));
	document.getElementById('form_id_temppages').setAttribute('type', window.parent.document.getElementById('pages').getAttribute('type'));
	document.getElementById('counterform_id_temp').value=window.parent.gen;;

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
	
	refresh_first();

	
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
	

function remove_add_(id)
{
			attr_name= new Array();
			attr_value= new Array();
			var input = document.getElementById(id); 
			atr=input.attributes;
			for(v=0;v<30;v++)
				if(atr[v] )
				{
					if(atr[v].name.indexOf("add_")==0)
					{
						attr_name.push(atr[v].name.replace('add_',''));
						attr_value.push(atr[v].value);
						input.removeAttribute(atr[v].name);
						v--;
					}
				}
			for(v=0;v<attr_name.length; v++)
			{
				input.setAttribute(attr_name[v],attr_value[v])
			}
}

function remove_whitespace(node)
{
    var ttt;
	for (ttt=0; ttt < node.childNodes.length; ttt++)
	{
        if( node.childNodes[ttt] && node.childNodes[ttt].nodeType == '3' && !/\S/.test(  node.childNodes[ttt].nodeValue ) )
		{
			
			node.removeChild(node.childNodes[ttt]);
            ttt--;
		}
		else
		{
			if(node.childNodes[ttt].childNodes.length)
				remove_whitespace(node.childNodes[ttt]);
		}
	}
	return
}

function refresh_first()
{
		
	n=window.parent.gen;
	for(i=0; i<n; i++)
	{
		if(document.getElementById(i))
		{	
			for(z=0; z<document.getElementById(i).childNodes.length; z++)
				if(document.getElementById(i).childNodes[z].nodeType==3)
					document.getElementById(i).removeChild(document.getElementById(i).childNodes[z]);

			if(document.getElementById(i).getAttribute('type')=="type_map")
			{
				if_gmap_init(i);
				for(q=0; q<20; q++)
					if(document.getElementById(i+"_elementform_id_temp").getAttribute("long"+q))
					{
					
						w_long=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("long"+q));
						w_lat=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("lat"+q));
						w_info=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("info"+q));
						add_marker_on_map(i,q, w_long, w_lat, w_info, false);
					}
			}
			
			if(document.getElementById(i).getAttribute('type')=="type_mark_map")
			{
				if_gmap_init(i);
				w_long=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("long"+0));
				w_lat=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("lat"+0));
				w_info=parseFloat(document.getElementById(i+"_elementform_id_temp").getAttribute("info"+0));
				add_marker_on_map(i,0, w_long, w_lat, w_info, true);
			}
			
			
			
			if(document.getElementById(i).getAttribute('type')=="type_captcha" || document.getElementById(i).getAttribute('type')=="type_recaptcha")
			{
				if(document.getElementById(i).childNodes[10])
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				}
				else
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				}
				continue;
			}
			
			if(document.getElementById(i).getAttribute('type')=="type_section_break")
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				continue;
			}
						

			if(document.getElementById(i).childNodes[10])
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
			}
			else
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
			}
		}
	}
	
	for(i=0; i<=n; i++)
	{	
		if(document.getElementById(i))
		{
			type=document.getElementById(i).getAttribute("type");
				switch(type)
				{
					case "type_text":
					case "type_number":
					case "type_password":
					case "type_submitter_mail":
					case "type_own_select":
					case "type_country":
					case "type_hidden":
					case "type_map":
					{
						remove_add_(i+"_elementform_id_temp");
						break;
					}
					
					case "type_submit_reset":
					{
						remove_add_(i+"_element_submitform_id_temp");
						if(document.getElementById(i+"_element_resetform_id_temp"))
							remove_add_(i+"_element_resetform_id_temp");
						break;
					}
					
					case "type_captcha":
					{
						remove_add_("_wd_captchaform_id_temp");
						remove_add_("_element_refreshform_id_temp");
						remove_add_("_wd_captcha_inputform_id_temp");
						break;
					}
					
					case "type_recaptcha":
					{
						remove_add_("wd_recaptchaform_id_temp");
						break;
					}
						
					case "type_file_upload":
						{
							remove_add_(i+"_elementform_id_temp");
								break;
						}
						
					case "type_textarea":
						{
						remove_add_(i+"_elementform_id_temp");

								break;
						}
						
					case "type_name":
						{
						
						if(document.getElementById(i+"_element_titleform_id_temp"))
							{
							remove_add_(i+"_element_titleform_id_temp");
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");
							remove_add_(i+"_element_middleform_id_temp");
							}
							else
							{
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");

							}
							break;

						}
						
					case "type_phone":
						{
						
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");

							break;

						}
						case "type_address":
							{	
								remove_add_(i+"_street1form_id_temp");
								remove_add_(i+"_street2form_id_temp");
								remove_add_(i+"_cityform_id_temp");
								remove_add_(i+"_stateform_id_temp");
								remove_add_(i+"_postalform_id_temp");
								remove_add_(i+"_countryform_id_temp");
							
								break;
	
							}
							
						
					case "type_checkbox":
					case "type_radio":
						{
							is=true;
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}
						/*	if(document.getElementById(i+"_randomize").value=="yes")
								choises_randomize(i);*/
							
							break;
						}
						
					case "type_button":
						{
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}
							break;
						}
						
					case "type_time":
						{	
						if(document.getElementById(i+"_ssform_id_temp"))
							{
							remove_add_(i+"_ssform_id_temp");
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");
							}
							else
							{
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");
							}
							break;

						}
						
					case "type_date":
						{	
						remove_add_(i+"_elementform_id_temp");
						remove_add_(i+"_buttonform_id_temp");
							break;
						}
					case "type_date_fields":
						{	
						remove_add_(i+"_dayform_id_temp");
						remove_add_(i+"_monthform_id_temp");
						remove_add_(i+"_yearform_id_temp");
								break;
						}
				}	
		}
	}
	

	for(t=1;t<=form_view_max<?php echo $id ?>;t++)
	{
		if(document.getElementById('form_id_tempform_view'+t))
		{
			form_view_element=document.getElementById('form_id_tempform_view'+t);
			remove_whitespace(form_view_element);
			xy=form_view_element.childNodes.length-2;
			for(z=0;z<=xy;z++)
			{
				if(form_view_element.childNodes[z])
				if(form_view_element.childNodes[z].nodeType!=3)
				if(!form_view_element.childNodes[z].id)
				{
					del=true;
					GLOBAL_tr=form_view_element.childNodes[z];
					//////////////////////////////////////////////////////////////////////////////////////////
					for (x=0; x < GLOBAL_tr.firstChild.childNodes.length; x++)
					{
						table=GLOBAL_tr.firstChild.childNodes[x];
						tbody=table.firstChild;
						if(tbody.childNodes.length)
							del=false;
					}
					
					if(del)
					{
						form_view_element.removeChild(form_view_element.childNodes[z]);
					}

				}
			}
		}
	}


	for(i=1; i<=window.parent.form_view_max; i++)
		if(document.getElementById('form_id_tempform_view'+i))
		{
			document.getElementById('form_id_tempform_view'+i).parentNode.removeChild(document.getElementById('form_id_tempform_view_img'+i));
			document.getElementById('form_id_tempform_view'+i).removeAttribute('style');
		}
	
}


</script>
<?php 


}


function add($themes){

		JRequest::setVar( 'hidemainmenu', 1 );
		
		$document =& JFactory::getDocument();

		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';

		$document->addScript($cmpnt_js_path.'/jquery.js');
		$document->addScript($cmpnt_js_path.'/if_gmap.js');
		$document->addScript($cmpnt_js_path.'/formmaker1.js');
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
		
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_formmaker/css/style.css');
		
		$is_editor=false;
		
		$plugin =& JPluginHelper::getPlugin('editors', 'tinymce');
		if (isset($plugin->type))
		{ 
			$editor	=& JFactory::getEditor('tinymce');
			$is_editor=true;
		}
		
		JHTML::_('behavior.tooltip');	
		JHTML::_('behavior.calendar');
		JHTML::_('behavior.modal');
		?>

<script type="text/javascript">
if($)
if(typeof $.noConflict === 'function'){
   $.noConflict();
}
var already_submitted=false;

function refresh_()
{
				
	document.getElementById('form').value=document.getElementById('take').innerHTML;
	document.getElementById('counter').value=gen;
	
	
	
	
	
	n=gen;
	for(i=0; i<n; i++)
	{
		if(document.getElementById(i))
		{	
			for(z=0; z<document.getElementById(i).childNodes.length; z++)
				if(document.getElementById(i).childNodes[z].nodeType==3)
					document.getElementById(i).removeChild(document.getElementById(i).childNodes[z]);

			if(document.getElementById(i).getAttribute('type')=="type_captcha" || document.getElementById(i).getAttribute('type')=="type_recaptcha")
			{
				if(document.getElementById(i).childNodes[10])
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				}
				else
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				}
				continue;
			}
			
			if(document.getElementById(i).getAttribute('type')=="type_section_break")
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				continue;
			}
						

			if(document.getElementById(i).childNodes[10])
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
			}
			else
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
			}
		}
	}
	
	for(i=0; i<=n; i++)
	{	
		if(document.getElementById(i))
		{
			type=document.getElementById(i).getAttribute("type");
				switch(type)
				{
					case "type_text":
					case "type_number":
					case "type_password":
					case "type_submitter_mail":
					case "type_own_select":
					case "type_country":
					case "type_hidden":
					case "type_map":
					case "type_paypal_select":
					{
						remove_add_(i+"_elementform_id_temp");
						break;
					}
					
					case "type_submit_reset":
					{
						remove_add_(i+"_element_submitform_id_temp");
						if(document.getElementById(i+"_element_resetform_id_temp"))
							remove_add_(i+"_element_resetform_id_temp");
						break;
					}
					
					case "type_captcha":
					{
						remove_add_("_wd_captchaform_id_temp");
						remove_add_("_element_refreshform_id_temp");
						remove_add_("_wd_captcha_inputform_id_temp");
						break;
					}
					
					case "type_recaptcha":
					{
						document.getElementById("public_key").value = document.getElementById("wd_recaptchaform_id_temp").getAttribute("public_key");
						document.getElementById("private_key").value= document.getElementById("wd_recaptchaform_id_temp").getAttribute("private_key");
						document.getElementById("recaptcha_theme").value= document.getElementById("wd_recaptchaform_id_temp").getAttribute("theme");
						document.getElementById('wd_recaptchaform_id_temp').innerHTML='';
						remove_add_("wd_recaptchaform_id_temp");
						break;
					}
						
					case "type_file_upload":
						{
							remove_add_(i+"_elementform_id_temp");
								break;
						}
						
					case "type_textarea":
						{
						remove_add_(i+"_elementform_id_temp");

								break;
						}
						
					case "type_name":
						{
						
						if(document.getElementById(i+"_element_titleform_id_temp"))
							{
							remove_add_(i+"_element_titleform_id_temp");
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");
							remove_add_(i+"_element_middleform_id_temp");
							}
							else
							{
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");

							}
							break;

						}
						
					case "type_phone":
						{
						
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");

							break;

						}
						
					case "type_paypal_price":
						{
						
							remove_add_(i+"_element_dollarsform_id_temp");
							remove_add_(i+"_element_centsform_id_temp");

							break;

						}
						
						case "type_address":
							{	
								remove_add_(i+"_street1form_id_temp");
								remove_add_(i+"_street2form_id_temp");
								remove_add_(i+"_cityform_id_temp");
								remove_add_(i+"_stateform_id_temp");
								remove_add_(i+"_postalform_id_temp");
								remove_add_(i+"_countryform_id_temp");
							
								break;
	
							}
							
						
					case "type_checkbox":
					case "type_radio":
					case "type_paypal_checkbox":
					case "type_paypal_radio":
					case "type_paypal_shipping":
						{
							is=true;
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}
						/*	if(document.getElementById(i+"_randomize").value=="yes")
								choises_randomize(i);*/
							
							break;
						}
						
					case "type_button":
						{
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}
							break;
						}
						
					case "type_time":
						{	
						if(document.getElementById(i+"_ssform_id_temp"))
							{
							remove_add_(i+"_ssform_id_temp");
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");
							}
							else
							{
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");
							}
							break;

						}
						
					case "type_date":
						{	
						remove_add_(i+"_elementform_id_temp");
						remove_add_(i+"_buttonform_id_temp");
							break;
						}
					case "type_date_fields":
						{	
						remove_add_(i+"_dayform_id_temp");
						remove_add_(i+"_monthform_id_temp");
						remove_add_(i+"_yearform_id_temp");
								break;
						}
				}	
		}
	}
	
	for(i=1; i<=form_view_max; i++)
		if(document.getElementById('form_id_tempform_view'+i))
		{
			if(document.getElementById('page_next_'+i))
				document.getElementById('page_next_'+i).removeAttribute('src');
			if(document.getElementById('page_previous_'+i))
				document.getElementById('page_previous_'+i).removeAttribute('src');
			document.getElementById('form_id_tempform_view'+i).parentNode.removeChild(document.getElementById('form_id_tempform_view_img'+i));
			document.getElementById('form_id_tempform_view'+i).removeAttribute('style');
		}
		
	for(t=1;t<=form_view_max;t++)
	{
		if(document.getElementById('form_id_tempform_view'+t))
		{
			form_view_element=document.getElementById('form_id_tempform_view'+t);
			n=form_view_element.childNodes.length-2;
			for(z=0;z<=n;z++)
			{
				if(form_view_element.childNodes[z])
				if(form_view_element.childNodes[z].nodeType!=3)
				if(!form_view_element.childNodes[z].id)
				{
					del=true;
					GLOBAL_tr=form_view_element.childNodes[z];
					//////////////////////////////////////////////////////////////////////////////////////////
					for (x=0; x < GLOBAL_tr.firstChild.childNodes.length; x++)
					{
						table=GLOBAL_tr.firstChild.childNodes[x];
						tbody=table.firstChild;
						if(tbody.childNodes.length)
							del=false;
					}
					
					if(del)
					{
						form_view_element.removeChild(form_view_element.childNodes[z]);
					}

				}
			}
		}
	}

	document.getElementById('form_front').value=document.getElementById('take').innerHTML;
}

Joomla.submitbutton= function (pressbutton){

	var form = document.adminForm;
	if (already_submitted ) 
	{
		submitform( pressbutton );
		return;
	}

	if (pressbutton == 'cancel') 
	{
		submitform( pressbutton );
		return;
	}

	if (form.title.value == "")
	{
		alert( "The form must have a title." );	
		return ;
	}		

	tox='';
	
	for(t=1;t<=form_view_max;t++)
	{
		if(document.getElementById('form_id_tempform_view'+t))
		{
			form_view_element=document.getElementById('form_id_tempform_view'+t);
			n=form_view_element.childNodes.length-2;

			for(z=0;z<=n;z++)
			{
				if(form_view_element.childNodes[z].nodeType!=3)
				if(!form_view_element.childNodes[z].id)
				{
					GLOBAL_tr=form_view_element.childNodes[z];
					//////////////////////////////////////////////////////////////////////////////////////////
					for (x=0; x < GLOBAL_tr.firstChild.childNodes.length; x++)
					{
						table=GLOBAL_tr.firstChild.childNodes[x];
						tbody=table.firstChild;
						for (y=0; y < tbody.childNodes.length; y++)
						{
							tr=tbody.childNodes[y];
							l_label = document.getElementById( tr.id+'_element_labelform_id_temp').innerHTML;
							l_label = l_label.replace(/(\r\n|\n|\r)/gm," ");

							if(tr.getAttribute('type')=="type_address")
							{
								addr_id=parseInt(tr.id);
								tox=tox+addr_id+'#**id**#'+'Street Line'+'#**label**#'+tr.getAttribute('type')+'#****#';addr_id++; 
								tox=tox+addr_id+'#**id**#'+'Street Line2'+'#**label**#'+tr.getAttribute('type')+'#****#';addr_id++; 
								tox=tox+addr_id+'#**id**#'+'City'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
								tox=tox+addr_id+'#**id**#'+'State'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
								tox=tox+addr_id+'#**id**#'+'Postal'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
								tox=tox+addr_id+'#**id**#'+'Country'+'#**label**#'+tr.getAttribute('type')+'#****#'; 
							}
							else
								tox=tox+tr.id+'#**id**#'+l_label+'#**label**#'+tr.getAttribute('type')+'#****#';
						}
					}
				}
			}
		}
	}

		document.getElementById('label_order').value=tox;
		document.getElementById('label_order_current').value=tox;
		refresh_();
		document.getElementById('pagination').value=document.getElementById('pages').getAttribute("type");
		document.getElementById('show_title').value=document.getElementById('pages').getAttribute("show_title");
		document.getElementById('show_numbers').value=document.getElementById('pages').getAttribute("show_numbers");
		already_submitted= true; 
		submitform( pressbutton );

}

gen=1; 
form_view=1; 
form_view_max=1; 
form_view_count=1;

 //add main form  id
    function enable()
	{
		alltypes=Array('customHTML','text','checkbox','radio','time_and_date','select','file_upload','captcha','map','button','page_break','section_break','paypal');
		for(x=0; x<13;x++)
		{
			document.getElementById('img_'+alltypes[x]).src="components/com_formmaker/images/"+alltypes[x]+".png";
		}
	
		if(document.getElementById('formMakerDiv').style.display=='block'){jQuery('#formMakerDiv').slideToggle(200);}else{jQuery('#formMakerDiv').slideToggle(400);}
		
		if(document.getElementById('formMakerDiv').offsetWidth)
			document.getElementById('formMakerDiv1').style.width	=(document.getElementById('formMakerDiv').offsetWidth - 60)+'px';
		
		if(document.getElementById('formMakerDiv1').style.display=='block'){jQuery('#formMakerDiv1').slideToggle(200);}else{jQuery('#formMakerDiv1').slideToggle(400);}
		document.getElementById('when_edit').style.display		='none';
	}

    function enable2()
	{
		alltypes=Array('customHTML','text','checkbox','radio','time_and_date','select','file_upload','captcha','map','button','page_break','section_break', 'paypal');
		for(x=0; x<13;x++)
		{
			document.getElementById('img_'+alltypes[x]).src="components/com_formmaker/images/"+alltypes[x]+".png";
		}
	
		if(document.getElementById('formMakerDiv').style.display=='block'){jQuery('#formMakerDiv').slideToggle(200);}else{jQuery('#formMakerDiv').slideToggle(400);}
		
		if(document.getElementById('formMakerDiv').offsetWidth)
			document.getElementById('formMakerDiv1').style.width	=(document.getElementById('formMakerDiv').offsetWidth - 60)+'px';
		
		if(document.getElementById('formMakerDiv1').style.display=='block'){jQuery('#formMakerDiv1').slideToggle(200);}else{jQuery('#formMakerDiv1').slideToggle(400);}
		document.getElementById('when_edit').style.display		='block';
		
		if(document.getElementById('field_types').offsetWidth)
			document.getElementById('when_edit').style.width	=document.getElementById('field_types').offsetWidth+'px';
		
		if(document.getElementById('field_types').offsetHeight)
			document.getElementById('when_edit').style.height	=document.getElementById('field_types').offsetHeight+'px';
		
	}
   
    </script>
    


<style>
#when_edit
{
position:absolute;
background-color:#666;
z-index:101;
display:none;
width:100%;
height:100%;
opacity: 0.7;
filter: alpha(opacity = 70);
}
#formMakerDiv
{
position:fixed;
background-color:#666;
z-index:100;
display:none;
left:0;
top:0;
width:100%;
height:100%;
opacity: 0.7;
filter: alpha(opacity = 70);
}
#formMakerDiv1
{
position:fixed;
z-index:100;
background-color:transparent;
top:0;
left:0;
display:none;
margin-left:30px;
margin-top:35px;
}

input[type="radio"], input[type="checkbox"] {
margin: 0px 4px 5px 5px;
}


.pull-left
{
float:none !important;
}

.modal-body
{
max-height:100%;
}

.wdform_date
{
margin:0px !important;
}

img
{
max-width:none;
}

.formmaker_table input
{
border-radius: 3px;
padding: 2px;
}

.formmaker_table
{
border-radius:8px;
border:6px #00aeef solid;
background-color:#00aeef;
height:120px;
}

.formMakerDiv1_table
{
border:6px #00aeef solid;
background-color:#FFF;
border-radius:8px;
}



</style>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">


<div  class="formmaker_table" width="100%" >
<div style="float:left; text-align:center">
 	</br>
   <img src="components/com_formmaker/images/FormMaker.png" />
	</br>
	</br>
   <img src="components/com_formmaker/images/logo.png" />

</div>

<div style="float:right">

    <span style="font-size:16.76pt; font-family:tahoma; color:#FFFFFF; vertical-align:middle;">Form title:&nbsp;&nbsp;</span>

    <input id="title" name="title" style="width:151px; height:19px; border:none; font-size:11px; " value=""/>
   <br/>
	<a href="#" onclick="Joomla.submitbutton('form_options_temp')" style="cursor:pointer;margin:10px; float:right; color:#fff; font-size:20px"><img src="components/com_formmaker/images/formoptions.png" /></a>    
   <br/>
	<img src="components/com_formmaker/images/addanewfield.png" onclick="enable(); Enable()" style="cursor:pointer;margin:10px; float:right" />

</div>
	
  

</div>
  
  
  
<div id="formMakerDiv" onclick="close_window()"></div>   

<div id="formMakerDiv1" align="center">
    
<table border="0" width="100%" cellpadding="0" cellspacing="0" height="100%" style="border:6px #00aeef solid; background-color:#FFF">
  <tr>
    <td style="padding:0px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
        <tr valign="top">
         <td width="15%" height="100%" style="border-right:dotted black 1px;" id="field_types">
         <div id="when_edit" style="display:none"></div>
            <table border="0" cellpadding="0" cellspacing="3" width="100%" style="border-collapse: separate; border-spacing: 3px;">
           <tr>
            <td align="center" onClick="addRow('customHTML')" id="table_editor" class="field_buttons"><img src="components/com_formmaker/images/customHTML.png" style="margin:5px" id="img_customHTML"/></td>
            
            <td align="center" onClick="addRow('text')" id="table_text" class="field_buttons"><img src="components/com_formmaker/images/text.png" style="margin:5px" id="img_text"/></td>
            </tr>
            <tr>
            <td align="center" onClick="addRow('time_and_date')" id="table_time_and_date" class="field_buttons"><img src="components/com_formmaker/images/time_and_date.png" style="margin:5px" id="img_time_and_date"/></td>
            
            <td align="center" onClick="addRow('select')" id="table_select" class="field_buttons" ><img src="components/com_formmaker/images/select.png" style="margin:5px" id="img_select"/></td>
            </tr>
            <tr>             
            <td align="center" onClick="addRow('checkbox')" id="table_checkbox" class="field_buttons"><img src="components/com_formmaker/images/checkbox.png" style="margin:5px" id="img_checkbox"/></td>
            
            <td align="center" onClick="addRow('radio')" id="table_radio" class="field_buttons"><img src="components/com_formmaker/images/radio.png" style="margin:5px" id="img_radio"/></td>
            </tr>
            <tr>
            <td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" id="table_file_upload" class="field_buttons"><img src="components/com_formmaker/images/file_upload.png" style="margin:5px" id="img_file_upload"/></td>
            
            <td align="center" onClick="addRow('captcha')" id="table_captcha" class="field_buttons"><img src="components/com_formmaker/images/captcha.png" style="margin:5px" id="img_captcha"/></td>
            </tr>
            <tr>
            <td align="center" onClick="addRow('page_break')" id="table_page_break" class="field_buttons"><img src="components/com_formmaker/images/page_break.png" style="margin:5px" id="img_page_break"/></td>  
            
            <td align="center" onClick="addRow('section_break')" id="table_section_break" class="field_buttons"><img src="components/com_formmaker/images/section_break.png" style="margin:5px" id="img_section_break"/></td>
            </tr>
            <tr>
            <td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" id="table_map" class="field_buttons"><img src="components/com_formmaker/images/map.png" style="margin:5px" id="img_map"/></td>  
  			<td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" id="table_paypal" class="field_buttons"><img src="components/com_formmaker/images/paypal.png" style="margin:5px" id="img_paypal" /></td>       
            </tr>		
			<tr>
            <td align="center" onClick="addRow('button')" id="table_button" class="field_buttons" colspan=2><img src="components/com_formmaker/images/button.png" style="margin:5px" id="img_button"/></td>
			
            </tr>

            </table>
         
		</td>
         <td width="35%" height="100%" align="left"><div id="edit_table" style="padding:0px; overflow-y:scroll; height:535px" ></div></td>
   <td align="center" valign="top" style="background:url(components/com_formmaker/images/border2.png) repeat-y;">&nbsp;</td>
         <td style="padding:15px">
         <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
         
            <tr>
                <td align="right"><input type="radio" value="end" name="el_pos" checked="checked" id="pos_end" onclick="Disable()"/>
                  At The End
                  <input type="radio" value="begin" name="el_pos" id="pos_begin" onclick="Disable()"/>
                  At The Beginning
                  <input type="radio" value="before" name="el_pos" id="pos_before" onclick="Enable()"/>
                  Before
                  <select style="width:100px; margin-left:5px" id="sel_el_pos" disabled="disabled">
                  </select>
                  <img alt="ADD" title="add" style="cursor:pointer; vertical-align:middle; margin:5px" src="components/com_formmaker/images/save.png" onClick="add(0)"/>
                  <img alt="CANCEL" title="cancel"  style=" cursor:pointer; vertical-align:middle; margin:5px" src="components/com_formmaker/images/cancel_but.png" onClick="close_window()"/>
				
                	<hr style=" margin-bottom:10px" />
                  </td>
              </tr>
              
              <tr height="100%" valign="top">
                <td  id="show_table"></td>
              </tr>
              
            </table>
         </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<input type="hidden" id="old" />
<input type="hidden" id="old_selected" />
<input type="hidden" id="element_type" />
<input type="hidden" id="editing_id" />
<input type="hidden" id="editing_page_break" />
<div id="main_editor" style="position:absolute; display:none; z-index:140;"><?php if($is_editor) echo $editor->display('editor','','440','350','40','6');
else
{
?>
<textarea name="editor" id="editor" cols="40" rows="6" style="width: 440px; height: 350px; " class="mce_editable" aria-hidden="true"></textarea>
<?php

}
 ?></div>

</div>


<?php if(!$is_editor)
?>
<iframe id="editor_ifr" style="display:none"></iframe>

<?php
?>

<br />
<br />

<fieldset>

    <legend>

    <h2 style="color:#00aeef">Form</h2>
    
    </legend>

     <style><?php echo self::first_css; ?></style>

<table width="100%" style="margin:8px"><tr id="page_navigation"><td align="center" width="90%" id="pages" show_title="false" show_numbers="true" type="none"></td><td align="left" id="edit_page_navigation"></td></tr></table>
<div id="take" class="main"><table cellpadding="4" cellspacing="0" class="wdform_table1" style="border-top:0px solid black;"><tbody id="form_id_tempform_view1" class="wdform_tbody1" page_title="Untitled page" next_title="Next" next_type="button" next_class="wdform_page_button" next_checkable="false" previous_title="Previous" previous_type="button" previous_class="wdform_page_button" previous_checkable="false"><tr class="wdform_tr1" ><td class="wdform_td1" ><table class="wdform_table2"><tbody class="wdform_tbody2"></tbody></table></td></tr><tr class="wdform_footer"><td colspan="100" valign="top"><table width="100%" style="padding-right:170px"><tbody><tr id="form_id_temppage_nav1"></tr></tbody></table></td></tr><tbody id="form_id_tempform_view_img1" style="float:right ;" ><tr><td width="0%"></td><td align="right"><img src="components/com_formmaker/images/minus.png" title="Show or hide the page" class="page_toolbar" onclick="show_or_hide('1')" id="show_page_img_1" /></td><td><img src="components/com_formmaker/images/page_delete.png" title="Delete the page"  class="page_toolbar" onclick="remove_page('1')" /></td><td><img src="components/com_formmaker/images/page_delete_all.png" title="Delete the page with fields"  class="page_toolbar" onclick="remove_page_all('1')" /></td><td><img src="components/com_formmaker/images/page_edit.png" title="Edit the page"  class="page_toolbar" onclick="edit_page_break('1')" /></td></tr></tbody></table></div>
</fieldset>

    <input type="hidden" name="form_front" id="form_front" />
    <input type="hidden" name="form" id="form" />
 	<?php 
	$form_theme='';
	foreach($themes as $theme) 
	{
		if($theme->default == 1 )
			$form_theme=$theme->id;		
	}
	?>
	<input type="hidden" name="theme" id="theme" value="<?php echo $form_theme?>" />

    <input type="hidden" name="mail" id="mail" />

    <input type="hidden" name="counter" id="counter" />
    
    <input type="hidden" name="pagination" id="pagination" />
    <input type="hidden" name="show_title" id="show_title" />
    <input type="hidden" name="show_numbers" id="show_numbers" />
    <input type="hidden" name="payment_currency" id="show_numbers" value="USD"/>
	
    <input type="hidden" name="public_key" id="public_key" />
    <input type="hidden" name="private_key" id="private_key" />
    <input type="hidden" name="recaptcha_theme" id="recaptcha_theme" />
	<input type="hidden" name="javascript" id="javascript" value="// before form is load
function before_load()
{

}

// before form submit
function before_submit()
{

}

// before form reset
function before_reset()
{

}">

	<input type="hidden" name="script_mail" id="script_mail" value="%all%" />
	<input type="hidden" name="script_mail_user" id="script_mail_user"  value="%all%" />
	<input type="hidden" name="label_order" id="label_order" />
	<input type="hidden" name="label_order_current" id="label_order_current" />
    <input type="hidden" name="option" value="com_formmaker" />

    <input type="hidden" name="task" value="" />

</form>



<script>
	appWidth			=parseInt(document.body.offsetWidth);
	appHeight			=parseInt(document.body.offsetHeight);
//	document.getElementById('toolbar-popup-preview').childNodes[1].href='index.php?option=com_formmaker&task=preview&format=raw&theme='+document.getElementById('theme').value;
//	document.getElementById('toolbar-popup-preview').childNodes[1].setAttribute('rel',"{handler: 'iframe', size: {x:"+(appWidth-100)+", y: "+531+"}}");
	
	
	jQuery('#modal-preview').on('show', function () {
document.getElementById('modal-preview-container').innerHTML = '<div class="modal-body"><iframe class="iframe" src="index.php?option=com_formmaker&task=preview&format=raw&theme='+document.getElementById('theme').value+'" height="'+(appHeight-200)+"px"+'" width="100%" style="border:0px"></iframe></div>';
});

document.getElementById('modal-preview').style.width=(appWidth-130)+"px";
document.getElementById('modal-preview').style.height=(appHeight-90)+"px";
document.getElementById('modal-preview').style.left="50px";
document.getElementById('modal-preview').style.top="30px";
document.getElementById('modal-preview').style.margin="0px";
</script>

<?php

$bar=& JToolBar::getInstance( 'toolbar' );
$bar->appendButton( 'popup', 'preview', 'Preview', 'index.php?option=com_formmaker&task=preview&format=raw', '617', '500' );

		

	}

function show_submits(&$rows, &$forms, &$lists, &$pageNav, &$labels, $label_titles, $rows_ord, $filter_order_Dir,$form_id, $labels_id, $sorted_labels_type, $total_entries, $total_views, $where, $where3)
{
	$label_titles_copy=$label_titles;
	JHTML::_('behavior.tooltip');
	JHTML::_('behavior.calendar');
	JHTML::_('behavior.modal');
	$mainframe = &JFactory::getApplication();
JSubMenuHelper::addEntry(JText::_('Forms'), 'index.php?option=com_formmaker&amp;task=forms' );
JSubMenuHelper::addEntry(JText::_('Submissions'), 'index.php?option=com_formmaker&amp;task=submits',true );
JSubMenuHelper::addEntry(JText::_('Themes'), 'index.php?option=com_formmaker&amp;task=themes' );
	$language = JFactory::getLanguage();
	$language->load('com_formmaker', JPATH_SITE, null, true);	

	$n=count($rows);
	$m=count($labels);
	$group_id_s= array();
	
	$rows_ord_none=array();
	
	if(count($rows_ord)>0 and $m)
	for($i=0; $i <count($rows_ord) ; $i++)
	{
	
		$row = &$rows_ord[$i];
	
		if(!in_array($row->group_id, $group_id_s))
		{
		
			array_push($group_id_s, $row->group_id);
			
		}
	}
	?>

<script type="text/javascript">
Joomla.tableOrdering=  function( order, dir, task ) 
{
    var form = document.adminForm;
    form.filter_order2.value     = order;
    form.filter_order_Dir2.value = dir;
    submitform( task );
}

function renderColumns()
{
	allTags=document.getElementsByTagName('*');
	
	for(curTag in allTags)
	{
		if(typeof(allTags[curTag].className)!="undefined")
		if(allTags[curTag].className.indexOf('_fc')>0)
		{
			curLabel=allTags[curTag].className.replace('_fc','');
			if(document.forms.adminForm.hide_label_list.value.indexOf('@'+curLabel+'@')>=0)
				allTags[curTag].style.display = 'none';
			else
				allTags[curTag].style.display = '';
		}
	}
}

function clickLabChB(label, ChB)
{
	document.forms.adminForm.hide_label_list.value=document.forms.adminForm.hide_label_list.value.replace('@'+label+'@','');
	if(document.forms.adminForm.hide_label_list.value=='') document.getElementById('ChBAll').checked=true;
	
	if(!(ChB.checked)) 
	{
		document.forms.adminForm.hide_label_list.value+='@'+label+'@';
		document.getElementById('ChBAll').checked=false;
	}
	renderColumns();
}

function toggleChBDiv(b)
{
	if(b)
	{
		sizes=window.getSize();
		document.getElementById("sbox-overlay").style.width=sizes.x+"px";
		document.getElementById("sbox-overlay").style.height=sizes.y+"px";
		document.getElementById("ChBDiv").style.left=Math.floor((sizes.x-350)/2)+"px";
		
		document.getElementById("ChBDiv").style.display="block";
		document.getElementById("sbox-overlay").style.display="block";
	}
	else
	{
		document.getElementById("ChBDiv").style.display="none";
		document.getElementById("sbox-overlay").style.display="none";
	}
}

function clickLabChBAll(ChBAll)
{
	<?php
	if(isset($labels))
	{
		$templabels=array_merge(array('submitid','submitdate','submitterip'),$labels_id);
		$label_titles=array_merge(array('ID','Submit date', 'Submitter\'s IP Address'),$label_titles);
	}
	?>

	if(ChBAll.checked)
	{ 
		document.forms.adminForm.hide_label_list.value='';

		for(i=0; i<=ChBAll.form.length; i++)
			if(typeof(ChBAll.form[i])!="undefined")
				if(ChBAll.form[i].type=="checkbox")
					ChBAll.form[i].checked=true;
	}
	else
	{
		document.forms.adminForm.hide_label_list.value='@<?php echo implode($templabels,'@@') ?>@'+'@payment_info@';

		for(i=0; i<=ChBAll.form.length; i++)
			if(typeof(ChBAll.form[i])!="undefined")
				if(ChBAll.form[i].type=="checkbox")
					ChBAll.form[i].checked=false;
	}

	renderColumns();
}

function remove_all()
{
	document.getElementById('startdate').value='';
	document.getElementById('enddate').value='';
	document.getElementById('ip_search').value='';
	<?php
		$n=count($rows);
	
	for($i=0; $i < count($labels) ; $i++)
	{
	echo "
	if(document.getElementById('".$form_id.'_'.$labels_id[$i]."_search'))
		document.getElementById('".$form_id.'_'.$labels_id[$i]."_search').value='';
	";
	}
	?>
}

function show_hide_filter()
{	
	if(document.getElementById('fields_filter').style.display=="none")
	{
		document.getElementById('fields_filter').style.display='';
		document.getElementById('filter_img').src='components/com_formmaker/images/filter_hide.png';
	}
	else
	{
		document.getElementById('fields_filter').style.display="none";
		document.getElementById('filter_img').src='components/com_formmaker/images/filter_show.png';
	}
}
</script>

<style>
.reports
{
	border:1px solid #DEDEDE;
	border-radius:11px;
	background-color:#F0F0F0;
	text-align:center;
	width:100px;
}

.bordered
{
	border-radius:8px
}

pre
{
background:none;
border:0px;
}

#fields_filter th
{
vertical-align:middle !important;
}

input[type="radio"], input[type="checkbox"] {
margin: 0px 4px 5px 5px;
}

select{
margin: 0px !important;
}
</style>
<?php 
if(isset($labels))
{
?>
<div id="sbox-overlay" style="z-index: 65555; position: fixed; top: 0px; left: 0px; visibility: visible; zoom: 1; background-color:#000000; opacity: 0.7; filter: alpha(opacity=70); display:none;" onclick="toggleChBDiv(false)"></div>
<div style="background-color:#FFFFFF; width: 350px; height: 350px; overflow-y: scroll; padding: 20px; position: fixed; top: 100px;display:none; border:2px solid #AAAAAA;  z-index:65556" id="ChBDiv">

<form action="#">
    <p style="font-weight:bold; font-size:18px;margin-top: 0px;">
    Select Columns
    </p>

    <input type="checkbox" <?php if($lists['hide_label_list']==='') echo 'checked="checked"' ?> onclick="clickLabChBAll(this)" id="ChBAll" />All</br>

	<?php 
    
        foreach($templabels as $key => $curlabel)
        {
            if(strpos($lists['hide_label_list'],'@'.$curlabel.'@')===false)
            echo '<input type="checkbox" checked="checked" onclick="clickLabChB(\''.$curlabel.'\', this)" />'.$label_titles[$key].'<br />';
            else
            echo '<input type="checkbox" onclick="clickLabChB(\''.$curlabel.'\', this)" />'.$label_titles[$key].'<br />';
        }
    
    
    ?>
    <br />
    <div style="text-align:center;">
        <input type="button" onclick="toggleChBDiv(false);" value="Done"  class="btn" /> 
    </div>
</form>
</div>

<?php } ?>

<form action="index.php?option=com_formmaker&task=submits" method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="option" value="com_formmaker">
    <input type="hidden" name="task" value="submits">
<br />
    <table width="100%" style="border-collapse: separate; border-spacing: 2px;">

        <tr >
            <td align="left" width="300"> Select a form:             
                <select name="form_id" id="form_id" onchange="if(document.getElementById('startdate'))remove_all();document.adminForm.submit();">
                    <option value="0" selected="selected"> Select a Form </option>
                    <?php 
            $option='com_formmaker';
            
            if( $forms)
            for($i=0, $n=count($forms); $i < $n ; $i++)
        
            {
                $form = &$forms[$i];
        
        
                if($form_id==$form->id)
                {
                    echo "<option value='".$form->id."' selected='selected'>".$form->title."</option>";
                    $form_title=$form->title;
                }
                else
                    echo "<option value='".$form->id."' >".$form->title."</option>";
            }
        ?>
                    </select>
            </td>
			<?php if(isset($form_id) and $form_id>0):  ?>
			<td class="reports" ><strong>Entries</strong><br /><?php echo $total_entries; ?></td>
			<td class="reports"><strong>Views</strong><br /><?php echo $total_views ?></td>
            <td class="reports"><strong>Conversion Rate</strong><br /><?php  if($total_views) echo round((($total_entries/$total_views)*100),2).'%'; else echo '0%' ?></td>
			<td style="font-size:24px;text-align:center;">
				<?php echo $form_title ?>
			</td>
			
			
			
        </tr>
        
        <tr>

            <td colspan=5>
                <br />
                <input type="hidden" name="hide_label_list" value="<?php  echo $lists['hide_label_list']; ?>" /> 
                <img id="filter_img" src="components/com_formmaker/images/filter_show.png" width="40" style="vertical-align:middle; cursor:pointer" onclick="show_hide_filter()"  title="Search by fields" />
				<button class="btn tip hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="remove_all();this.form.submit();" data-original-title="Clear">
				<i class="icon-remove"></i></button>
            </td>
			<td align="right">
                <br /><br />
                <?php if(isset($labels)) echo '<input type="button" class="btn" onclick="toggleChBDiv(true)" value="Add/Remove Columns" />'; ?>
				<?php echo $pageNav->getLimitBox(); ?>

			</td>
        </tr>

		<?php else: echo '<td><br /><br /><br /></td></tr>'; endif; ?>
    </table>
    <table class="table table-striped" width="100%">
        <thead>
            <tr>

                <th width="3%"><?php echo '#'; ?></th>

				<th width="4%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				
				 <?php
				 echo '<th width="4%" class="submitid_fc"';
				 if(!(strpos($lists['hide_label_list'],'@submitid@')===false)) 
				 echo 'style="display:none;"';
				 echo '>';
				 echo JHTML::_('grid.sort', 'Id', 'group_id', @$lists['order_Dir'], @$lists['order'] );
				 echo '</th>';
				 
				 echo '<th width="150" class="submitdate_fc"';
				 if(!(strpos($lists['hide_label_list'],'@submitdate@')===false)) 
				 echo 'style="display:none;"';
				 echo '>';
				 echo JHTML::_('grid.sort', 'Submit date', 'date', @$lists['order_Dir'], @$lists['order'] );
				 echo '</th>';

				 echo '<th width="100" class="submitterip_fc"';
				 if(!(strpos($lists['hide_label_list'],'@submitterip@')===false)) 
				 echo 'style="display:none;"';
				 echo '>';
				 echo JHTML::_('grid.sort', 'Submitter\'s IP Address', 'ip', @$lists['order_Dir'], @$lists['order'] );
				 echo '</th>';
				 
				 
	$n=count($rows);
	$ispaypal=false;
	
	for($i=0; $i < count($labels) ; $i++)
	{
		if(strpos($lists['hide_label_list'],'@'.$labels_id[$i].'@')===false)  $styleStr='';
		else $styleStr='style="display:none;"';
		
		if($sorted_labels_type[$i]=='type_address')		
			switch($label_titles_copy[$i])
			{
			case 'Street Line': $field_title=JText::_('WDF_STREET_ADDRESS'); break;
			case 'Street Line2': $field_title=JText::_('WDF_STREET_ADDRESS2'); break;
			case 'City': $field_title=JText::_('WDF_CITY'); break;
			case 'State': $field_title=JText::_('WDF_STATE'); break;
			case 'Postal': $field_title=JText::_('WDF_POSTAL'); break;
			case 'Country': $field_title=JText::_('WDF_COUNTRY'); break;
			default : $field_title=$label_titles_copy[$i]; break;			
			}
		else
			$field_title=$label_titles_copy[$i];
			
		if($sorted_labels_type[$i]=='type_paypal_payment_status')		
		{	
			$ispaypal=true;
			echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.JHTML::_('grid.sort', $field_title, $labels_id[$i]."_field", @$lists['order_Dir'], @$lists['order'] ).'</th>';
						if(strpos($lists['hide_label_list'],'@payment_info@')===false)  
							$styleStr2='aa';
                        else 
							$styleStr2='style="display:none;"';
							
			echo '<th class="payment_info_fc" '.$styleStr2.'>Payment Info</th>';
			}
		else
			echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.JHTML::_('grid.sort', $field_title, $labels_id[$i]."_field", @$lists['order_Dir'], @$lists['order'] ).'</th>';
	}
?>

            </tr>
            <tr id="fields_filter" style="display:none; background:#F1F1F1">
                <th width="3%"></th>
                <th width="3%"></th>
				<th width="4%" class="submitid_fc" <?php if(!(strpos($lists['hide_label_list'],'@submitid@')===false)) echo 'style="display:none;"';?> ></th>
				
				
				<th width="150" class="submitdate_fc" style="text-align:left; <?php if(!(strpos($lists['hide_label_list'],'@submitdate@')===false)) echo 'display:none;';?>" align="center"> 
				<table class="simple_table">
					<tr class="simple_table">
						<td class="simple_table">From:</td>
						<td class="simple_table"><input class="inputbox" type="text" name="startdate" id="startdate" style="width:70px" maxlength="10" value="<?php echo $lists['startdate'];?>" /> </td>
						<td class="simple_table">
						<button class="btn" id="startdate_but"><i class="icon-calendar"></i></button>
						</td>
					</tr>
					<tr class="simple_table">
						<td class="simple_table">To:</td>
						<td class="simple_table"><input class="inputbox" type="text" name="enddate" id="enddate" style="width:70px" maxlength="10" value="<?php echo $lists['enddate'];?>" /> </td>
						<td class="simple_table">
						<button class="btn" id="enddate_but"><i class="icon-calendar"></i></button>
						</td>
					</tr>
				</table>
				
				</th>
				
				
				
				
				<th width="100"class="submitterip_fc"  <?php if(!(strpos($lists['hide_label_list'],'@submitterip@')===false)) echo 'style="display:none;"';?>>
                 <input type="text" name="ip_search" id="ip_search" value="<?php echo $lists['ip_search'] ?>" onChange="this.form.submit();" style="width:150px"/>
				</th>
				<?php				 
                    $n=count($rows);
					$ka_fielderov_search=false;
					
					if($lists['ip_search'] || $lists['startdate'] || $lists['enddate']){
						$ka_fielderov_search=true;
					}
					
                    for($i=0; $i < count($labels) ; $i++)
                    {
                        if(strpos($lists['hide_label_list'],'@'.$labels_id[$i].'@')===false)  
							$styleStr='';
                        else 
							$styleStr='style="display:none;"';
						
						if(!$ka_fielderov_search)
							if($lists[$form_id.'_'.$labels_id[$i].'_search'])
							{
								$ka_fielderov_search=true;
							} 



						switch($sorted_labels_type[$i])
						{
							case 'type_mark_map': echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.'</th>'; break;
							case 'type_paypal_payment_status':
							echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>';
?>
<select name="<?php echo $form_id.'_'.$labels_id[$i]; ?>_search" id="<?php echo $form_id.'_'.$labels_id[$i]; ?>_search" onChange="this.form.submit();" value="<?php echo $lists[$form_id.'_'.$labels_id[$i].'_search']; ?>" >
	<option value="" ></option>
	<option value="canceled" >Canceled</option>
	<option value="cleared" >Cleared</option>
	<option value="cleared by payment review" >Cleared by payment review</option>
	<option value="completed" >Completed</option>
	<option value="denied" >Denied</option>
	<option value="failed" >Failed</option>
	<option value="held" >Held</option>
	<option value="in progress" >In progress</option>
	<option value="on hold" >On hold</option>
	<option value="paid" >Paid</option>
	<option value="partially refunded" >Partially refunded</option>
	<option value="pending verification" >Pending verification</option>
	<option value="placed" >Placed</option>
	<option value="processing" >Processing</option>
	<option value="refunded" >Refunded</option>
	<option value="refused" >Refused</option>
	<option value="removed" >Removed</option>
	<option value="returned" >Returned</option>
	<option value="reversed" >Reversed</option>
	<option value="temporary hold" >Temporary hold</option>
	<option value="unclaimed" >Unclaimed</option>
</select>	
<script> 
    var element = document.getElementById('<?php echo $form_id.'_'.$labels_id[$i]; ?>_search');
    element.value = '<?php echo $lists[$form_id.'_'.$labels_id[$i].'_search']; ?>';
</script>
		<?php				
							echo '</th>';
							
							 
						if(strpos($lists['hide_label_list'],'@payment_info@')===false)  
							$styleStr2='aa';
                        else 
							$styleStr2='style="display:none;"';
							
						echo	'<th class="payment_info_fc" '.$styleStr2.'></th>';
							
						
							break;
							default : 			  echo '<th class="'.$labels_id[$i].'_fc" '.$styleStr.'>'.'<input name="'.$form_id.'_'.$labels_id[$i].'_search" id="'.$form_id.'_'.$labels_id[$i].'_search" type="text" value="'.$lists[$form_id.'_'.$labels_id[$i].'_search'].'"  onChange="this.form.submit();" >'.'</th>'; break;			
						
						}
						
						
                 }
                ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="100"> <?php echo $pageNav->getListFooter(); ?>

				</td>
            </tr>
        </tfoot>

        <?php
    $k = 0;
	$m=count($labels);
	$group_id_s= array();
	$l=0;
	if(count($rows_ord)>0 and $m)
	for($i=0; $i <count($rows_ord) ; $i++)
	{
	
		$row = &$rows_ord[$i];
	
		if(!in_array($row->group_id, $group_id_s))
		{
		
			array_push($group_id_s, $row->group_id);
			
		}
	}
	

	for($www=0, $qqq=count($group_id_s); $www < $qqq ; $www++)
	{	
	$i=$group_id_s[$www];
	
		$temp= array();
		for($j=0; $j < $n ; $j++)
		{
			$row = &$rows[$j];
			if($row->group_id==$i)
			{
				array_push($temp, $row);
			}
		}
		$f=$temp[0];
		$date=$f->date;
		$ip=$f->ip;
		$checked 	= JHTML::_('grid.id', $www, $group_id_s[$www]);
		$link="index.php?option=com_formmaker&task=edit_submit&cid[]=".$f->group_id;
		?>

        <tr class="<?php echo "row$k"; ?>">

              <td align="center"><?php echo $www+1;?></td>

          <td align="center"><?php echo $checked?></td>
		  
<?php

if(strpos($lists['hide_label_list'],'@submitid@')===false)
echo '<td align="center" class="submitid_fc"><a href="'.$link.'" >'.$f->group_id.'</a></td>';
else 
echo '<td align="center" class="submitid_fc" style="display:none;"><a href="'.$link.'" >'.$f->group_id.'</a></td>';

if(strpos($lists['hide_label_list'],'@submitdate@')===false)
echo '<td align="center" class="submitdate_fc"><a href="'.$link.'" >'.$date.'</a></td>';
else 
echo '<td align="center" class="submitdate_fc" style="display:none;"><a href="'.$link.'" >'.$date.'</a></td>'; 

if(strpos($lists['hide_label_list'],'@submitterip@')===false)
echo '<td align="center" class="submitterip_fc"><a href="'.$link.'" >'.$ip.'</a></td>';
else 
echo '<td align="center" class="submitterip_fc" style="display:none;"><a href="'.$link.'" >'.$ip.'</a></td>';


		$ttt=count($temp);
		for($h=0; $h < $m ; $h++)
		{		
			$not_label=true;
			for($g=0; $g < $ttt ; $g++)
			{			
				$t = $temp[$g];
				if(strpos($lists['hide_label_list'],'@'.$labels_id[$h].'@')===false)  $styleStr='';
				else $styleStr='style="display:none;"';
				if($t->element_label==$labels_id[$h])
				{
					if(strpos($t->element_value,"***map***"))
					{
						$map_params=explode('***map***',$t->element_value);
						
						$longit	=$map_params[0];
						$latit	=$map_params[1];
						
						echo  '<td align="center" class="'.$labels_id[$h].'_fc" '.$styleStr.'><a class="modal"  href="index.php?option=com_formmaker&task=show_map&long='.$longit.'&lat='.$latit.'&tmpl=component" rel="{handler: \'iframe\', size: {x:630, y: 570}}">'.'Show on Map'."</a></td>";
					}
					else

						if(strpos($t->element_value,"*@@url@@*"))
						{
							$new_file=str_replace("*@@url@@*",'', str_replace("***br***",'<br>', $t->element_value));
							$new_filename=explode('/', $new_file);
							echo  '<td align="center" class="'.$labels_id[$h].'_fc" '.$styleStr.'><a target="_blank" href="'.$new_file.'">'.$new_filename[count($new_filename)-1]."</td>";
						}
						else
							echo  '<td align="center" class="'.$labels_id[$h].'_fc" '.$styleStr.'><pre style="font-family:inherit; white-space: pre;">'.str_replace("***br***",'<br>', $t->element_value).'</pre></td>';
					$not_label=false;
				}
			}
			if($not_label)
					echo  '<td align="center" class="'.$labels_id[$h].'_fc" '.$styleStr.'></td>';
		}
		
		if($ispaypal)
		{
			if(strpos($lists['hide_label_list'],'@payment_info@')===false)  $styleStr='';
				else $styleStr='style="display:none;"';
			echo  '<td align="center" class="payment_info_fc" '.$styleStr.'>		
			<a class="modal" href="index.php?option=com_formmaker&amp;task=paypal_info&amp;tmpl=component&amp;id='.$i.'" rel="{handler: \'iframe\', size: {x:703, y: 550}}">
	<img src="components/com_formmaker/images/info.png" /></a>
		
			</td>';
		}

?>
        </tr>

        <?php


		$k = 1 - $k;

	}

	?>

    </table>

	
	
        <?php
		    $db =& JFactory::getDBO();

foreach($sorted_labels_type as $key => $label_type)
{
	if($label_type=="type_checkbox" || $label_type=="type_radio" || $label_type=="type_own_select" || $label_type=="type_country")
	{	
		?>
<br />
<br />

        <strong><?php echo $label_titles_copy[$key]?></strong>
<br />
<br />

    <?php

		$query = "SELECT element_value FROM #__formmaker_submits ".$where3." AND element_label='".$labels_id[$key]."'";
		$db->setQuery( $query);
		$choices = $db->loadObjectList();
	
		if($db->getErrorNum()){
			echo $db->stderr();
			return false;}
			
	$colors=array('#2CBADE','#FE6400');
	$choices_labels=array();
	$choices_count=array();
	$all=count($choices);
	$unanswered=0;	
	foreach($choices as $key => $choice)
	{
		if($choice->element_value=='')
		{
			$unanswered++;
		}
		else
		{
			if(!in_array( $choice->element_value,$choices_labels))
			{
				array_push($choices_labels, $choice->element_value);
				array_push($choices_count, 0);
			}

			$choices_count[array_search($choice->element_value, $choices_labels)]++;
		}
	}
	array_multisort($choices_count,SORT_DESC,$choices_labels);
	?>
	<table width="50%" class="adminlist">
		<thead>
			<tr>
				<th width="20%">Choices</th>
				<th>Percentage</th>
				<th width="10%">Count</th>
			</tr>
		</thead>
    <?php 
	foreach($choices_labels as $key => $choices_label)
	{
	?>
		<tr>
			<td><?php echo str_replace("***br***",'<br>', $choices_label)?></td>
			<td><div class="bordered" style="width:<?php echo ($choices_count[$key]/($all-$unanswered))*100; ?>%; height:18px; background-color:<?php echo $colors[$key % 2]; ?>"></td>
			<td><?php echo $choices_count[$key]?></td>
		</tr>
    <?php 
	}
	
	if($unanswered){
	?>
    <tr>
    <td colspan="2" align="right">Unanswered</th>
    <td><strong><?php echo $unanswered;?></strong></th>
	</tr>

	<?php	
	}
	?>
    <tr>
    <td colspan="2" align="right"><strong>Total</strong></th>
    <td><strong><?php echo $all;?></strong></th>
	</tr>

	</table>
	<?php
	}
}
	?>

	
	
    <input type="hidden" name="boxchecked" value="0">

    <input type="hidden" name="filter_order2" value="<?php echo $lists['order']; ?>" />

    <input type="hidden" name="filter_order_Dir2" value="<?php echo $lists['order_Dir']; ?>" />

</form>

<script>
<?php if($ka_fielderov_search){?> 
document.getElementById('fields_filter').style.display='';
document.getElementById('filter_img').src='components/com_formmaker/images/filter_hide.png';
	<?php
 }?>
 
				Calendar.setup({
						inputField: "startdate",
						ifFormat: "%Y-%m-%d",
						button: "startdate_but",
						align: "Tl",
						singleClick: true,
						firstDay: 0
						});
						
				Calendar.setup({
						inputField: "enddate",
						ifFormat: "%Y-%m-%d",
						button: "enddate_but",
						align: "Tl",
						singleClick: true,
						firstDay: 0
						});


</script>

<?php


}

function show(&$rows, &$pageNav, &$lists){

JSubMenuHelper::addEntry(JText::_('Forms'), 'index.php?option=com_formmaker&amp;task=forms', true );
JSubMenuHelper::addEntry(JText::_('Submissions'), 'index.php?option=com_formmaker&amp;task=submits' );
JSubMenuHelper::addEntry(JText::_('Themes'), 'index.php?option=com_formmaker&amp;task=themes' );

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');


	?>
<script>

Joomla.tableOrdering= function ( order, dir, task )  {
    var form = document.adminForm;
    form.filter_order.value     = order;
    form.filter_order_Dir.value = dir;
    submitform( task );
}


 function SelectAll(obj) { obj.focus(); obj.select(); } 
 </script>
<form action="index.php?option=com_formmaker" method="post" name="adminForm" id="adminForm">

    <table width="100%">

        <tr>

            <td align="left" width="100%">
                <input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" placeholder="Search title" style="margin:0px" />

				<button class="btn tip hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('search').value='';this.form.submit();" data-original-title="Clear">
				<i class="icon-remove"></i></button>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $pageNav->getLimitBox(); ?>
				</div>


            </td>

        </tr>

    </table>

    <table class="table table-striped" width="100%" >

        <thead>

            <tr>

                <th width="4%"><?php echo '#'; ?></th>
                <th width="6%"><?php echo  JHTML::_('grid.sort', 'Id', 'Id', @$lists['order_Dir'], @$lists['order'] ); ?></th>

				<th width="4%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>

                <th width="34%"><?php echo JHTML::_('grid.sort', 'Title', 'title', @$lists['order_Dir'], @$lists['order'] ); ?></th>

                <th width="35%"><?php echo JHTML::_('grid.sort', 'Email to send submissions to', 'mail', @$lists['order_Dir'], @$lists['order'] ); ?></th>
				
                <th width="15%"><?php echo 'Plugin Code<br/>(Copy to article)'; ?></th>

            </tr>

        </thead>

        <tfoot>

            <tr>

                <td colspan="6"> <?php echo $pageNav->getListFooter(); ?> </td>

            </tr>

        </tfoot>

        <?php

	

    $k = 0;

	for($i=0, $n=count($rows); $i < $n ; $i++)

	{

		$row = &$rows[$i];

		$checked 	= JHTML::_('grid.id', $i, $row->id);

		$published 	= JHTML::_('grid.published', $row, $i); 


		// prepare link for id column

		$link 		= JRoute::_( 'index.php?option=com_formmaker&task=edit&cid[]='. $row->id );

		?>

        <tr class="<?php echo "row$k"; ?>">

                      <td align="center"><?php echo $i+1?></td>
                      <td align="center"><?php echo $row->id?></td>

          <td align="center"><?php echo $checked?></td>

            <td align="center"><a href="<?php echo $link; ?>"><?php echo $row->title?></a></td>

            <td align="center"><?php echo $row->mail?></td>
            <td align="center"><input type="text" readonly="readonly" value="{loadformmaker <?php echo $row->id?>}" onclick="SelectAll(this)" width="130"></td>

        </tr>

        <?php

		$k = 1 - $k;

	}

	?>

    </table>

    <input type="hidden" name="option" value="com_formmaker">
    <input type="hidden" name="task" value="forms">
    <input type="hidden" name="boxchecked" value="0"  >
    <input type="text" name="filter_order"  id="filter_order" value="<?php echo $lists['order']; ?>"  class="text_area" style="display:none"/>
    <input type="text" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" class="text_area" style="display:none" />


</form>

<?php
}

function edit(&$row, &$labels, &$themes){

JRequest::setVar( 'hidemainmenu', 1 );
		
		$document =& JFactory::getDocument();

		$cmpnt_js_path = JURI::root(true).'/administrator/components/com_formmaker/js';
		
		$document->addScript($cmpnt_js_path.'/jquery.js');
		$document->addScript($cmpnt_js_path.'/if_gmap.js');
		$document->addScript($cmpnt_js_path.'/formmaker1.js');
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_formmaker/css/style.css');
		
		$is_editor=false;
		
		$plugin =& JPluginHelper::getPlugin('editors', 'tinymce');
		if (isset($plugin->type))
		{ 
			$editor	=& JFactory::getEditor('tinymce');
			$is_editor=true;
		}
		

		JHTML::_('behavior.tooltip');	
		JHTML::_('behavior.calendar');
		JHTML::_('behavior.modal');
	?>
    
<script type="text/javascript">
if($)
if(typeof $.noConflict === 'function'){
   $.noConflict();
}
var already_submitted=false;

Joomla.submitbutton= function (pressbutton) 

{
	if (already_submitted) 
	{
		submitform( pressbutton );
		return;
	}

	var form = document.adminForm;

	if (pressbutton == 'cancel') 

	{

		submitform( pressbutton );

		return;

	}

	if(!document.getElementById('araqel'))
	{
		alert('Please wait while page loading');
		return;
	}
	else
		if(document.getElementById('araqel').value=='0')
		{
			alert('Please wait while page loading');
			return;
		}
		

	if (form.title.value == "")

	{

				alert( "The form must have a title." );	
				return;

	}		

	
		tox='';
		l_id_array=[<?php echo $labels['id']?>];
		l_label_array=[<?php echo $labels['label']?>];
		l_type_array=[<?php echo $labels['type']?>];
		l_id_removed=[];
		
		for(x=0; x< l_id_array.length; x++)
			{
				l_id_removed[x]=true;
			}

for(t=1;t<=form_view_max;t++)
{
	if(document.getElementById('form_id_tempform_view'+t))
	{
		form_view_element=document.getElementById('form_id_tempform_view'+t);
		n=form_view_element.childNodes.length-2;	
		
		for(q=0;q<=n;q++)
		{
				if(form_view_element.childNodes[q].nodeType!=3)
				if(!form_view_element.childNodes[q].id)
				{
					GLOBAL_tr=form_view_element.childNodes[q];
		
					for (x=0; x < GLOBAL_tr.firstChild.childNodes.length; x++)
					{
			
						table=GLOBAL_tr.firstChild.childNodes[x];
						tbody=table.firstChild;
						for (y=0; y < tbody.childNodes.length; y++)
						{
							is_in_old=false;
							tr=tbody.childNodes[y];
							l_id=tr.id;
				
							l_label=document.getElementById( tr.id+'_element_labelform_id_temp').innerHTML;
							l_label = l_label.replace(/(\r\n|\n|\r)/gm," ");
							l_type=tr.getAttribute('type');
							for(z=0; z< l_id_array.length; z++)
							{
								if(l_id_array[z]==l_id)
								{
									l_id_removed[z]=false;
									if(l_type_array[z]=="type_address")
									{
										z++;	
										l_id_removed[z]=false;
										z++;	
										l_id_removed[z]=false;
										z++;	
										l_id_removed[z]=false;
										z++;	
										l_id_removed[z]=false;
										z++;	
										l_id_removed[z]=false;
									}
								}
							}
							
								if(tr.getAttribute('type')=="type_address")
								{
									addr_id=parseInt(tr.id);
									tox=tox+addr_id+'#**id**#'+'Street Line'+'#**label**#'+tr.getAttribute('type')+'#****#';addr_id++; 
									tox=tox+addr_id+'#**id**#'+'Street Line2'+'#**label**#'+tr.getAttribute('type')+'#****#';addr_id++; 
									tox=tox+addr_id+'#**id**#'+'City'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
									tox=tox+addr_id+'#**id**#'+'State'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
									tox=tox+addr_id+'#**id**#'+'Postal'+'#**label**#'+tr.getAttribute('type')+'#****#';	addr_id++; 
									tox=tox+addr_id+'#**id**#'+'Country'+'#**label**#'+tr.getAttribute('type')+'#****#'; 
								}
								else
									tox=tox+l_id+'#**id**#'+l_label+'#**label**#'+l_type+'#****#';

							
							
						}
					}
				}
		}
	}	
}

	document.getElementById('label_order_current').value=tox;

	for(x=0; x< l_id_array.length; x++)
	{
		if(l_id_removed[x])
				tox=tox+l_id_array[x]+'#**id**#'+l_label_array[x]+'#**label**#'+l_type_array[x]+'#****#';
	}
	
	
	document.getElementById('label_order').value=tox;
	
	
	refresh_()
	document.getElementById('pagination').value=document.getElementById('pages').getAttribute("type");
	document.getElementById('show_title').value=document.getElementById('pages').getAttribute("show_title");
	document.getElementById('show_numbers').value=document.getElementById('pages').getAttribute("show_numbers");
	
	already_submitted=true;
	
		submitform( pressbutton );
}

function remove_whitespace(node)
{
    var ttt;
	for (ttt=0; ttt < node.childNodes.length; ttt++)
	{
        if( node.childNodes[ttt] && node.childNodes[ttt].nodeType == '3' && !/\S/.test(  node.childNodes[ttt].nodeValue ) )
		{
			
			node.removeChild(node.childNodes[ttt]);
            ttt--;
		}
		else
		{
			if(node.childNodes[ttt].childNodes.length)
				remove_whitespace(node.childNodes[ttt]);
		}
	}
	return
}

function refresh_()
{
			
	document.getElementById('form').value=document.getElementById('take').innerHTML;
	document.getElementById('counter').value=gen;
	n=gen;
	for(i=0; i<n; i++)
	{
		if(document.getElementById(i))
		{	
			for(z=0; z<document.getElementById(i).childNodes.length; z++)
				if(document.getElementById(i).childNodes[z].nodeType==3)
					document.getElementById(i).removeChild(document.getElementById(i).childNodes[z]);

			if(document.getElementById(i).getAttribute('type')=="type_captcha" || document.getElementById(i).getAttribute('type')=="type_recaptcha")
			{
				if(document.getElementById(i).childNodes[10])
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				}
				else
				{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				}
				continue;
			}
						
			if(document.getElementById(i).getAttribute('type')=="type_section_break")
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				continue;
			}
						


			if(document.getElementById(i).childNodes[10])
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[2]);
			}
			else
			{
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
				document.getElementById(i).removeChild(document.getElementById(i).childNodes[1]);
			}
		}
	}
	
	for(i=0; i<=n; i++)
	{	
		if(document.getElementById(i))
		{
			type=document.getElementById(i).getAttribute("type");
				switch(type)
				{
					case "type_text":
					case "type_number":
					case "type_password":
					case "type_submitter_mail":
					case "type_own_select":
					case "type_country":
					case "type_hidden":
					case "type_map":
					case "type_mark_map":
					case "type_paypal_select":
					{
						remove_add_(i+"_elementform_id_temp");
						break;
					}
					
					case "type_submit_reset":
					{
						remove_add_(i+"_element_submitform_id_temp");
						if(document.getElementById(i+"_element_resetform_id_temp"))
							remove_add_(i+"_element_resetform_id_temp");
						break;
					}
					
					case "type_captcha":
					{
						remove_add_("_wd_captchaform_id_temp");
						remove_add_("_element_refreshform_id_temp");
						remove_add_("_wd_captcha_inputform_id_temp");
						break;
					}
					
					case "type_recaptcha":
					{
						document.getElementById("public_key").value = document.getElementById("wd_recaptchaform_id_temp").getAttribute("public_key");
						document.getElementById("private_key").value= document.getElementById("wd_recaptchaform_id_temp").getAttribute("private_key");
						document.getElementById("recaptcha_theme").value= document.getElementById("wd_recaptchaform_id_temp").getAttribute("theme");
						document.getElementById('wd_recaptchaform_id_temp').innerHTML='';
						remove_add_("wd_recaptchaform_id_temp");
						break;
					}
						
					case "type_file_upload":
						{
							remove_add_(i+"_elementform_id_temp");
							
								break;
						}
						
					case "type_textarea":
						{
						remove_add_(i+"_elementform_id_temp");

								break;
						}
						
					case "type_name":
						{
						
							if(document.getElementById(i+"_element_titleform_id_temp"))
							{
								remove_add_(i+"_element_titleform_id_temp");
								remove_add_(i+"_element_firstform_id_temp");
								remove_add_(i+"_element_lastform_id_temp");
								remove_add_(i+"_element_middleform_id_temp");
							}
							else
							{
								remove_add_(i+"_element_firstform_id_temp");
								remove_add_(i+"_element_lastform_id_temp");
							}
								break;

						}
						
					case "type_phone":
						{
						
							remove_add_(i+"_element_firstform_id_temp");
							remove_add_(i+"_element_lastform_id_temp");
							break;

						}
					case "type_paypal_price":
						{
						
							remove_add_(i+"_element_dollarsform_id_temp");
							remove_add_(i+"_element_centsform_id_temp");
							break;

						}
						case "type_address":
							{	
								remove_add_(i+"_street1form_id_temp");
								remove_add_(i+"_street2form_id_temp");
								remove_add_(i+"_cityform_id_temp");
								remove_add_(i+"_stateform_id_temp");
								remove_add_(i+"_postalform_id_temp");
								remove_add_(i+"_countryform_id_temp");
							
								break;
	
							}
							
						
					case "type_checkbox":
					case "type_radio":
					case "type_paypal_checkbox":
					case "type_paypal_radio":
					case "type_paypal_shipping":
						{
							is=true;
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}

							/*if(document.getElementById(i+"_randomize").value=="yes")
								choises_randomize(i);*/
							
							break;
						}
						
					case "type_button":
						{
							for(j=0; j<100; j++)
								if(document.getElementById(i+"_elementform_id_temp"+j))
								{
									remove_add_(i+"_elementform_id_temp"+j);
								}
							break;
						}
						
					case "type_time":
						{	
						if(document.getElementById(i+"_ssform_id_temp"))
							{
							remove_add_(i+"_ssform_id_temp");
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");
							}
							else
							{
							remove_add_(i+"_mmform_id_temp");
							remove_add_(i+"_hhform_id_temp");

							}
							break;

						}
						
					case "type_date":
						{	
						remove_add_(i+"_elementform_id_temp");
						remove_add_(i+"_buttonform_id_temp");
						
							break;
						}
					case "type_date_fields":
						{	
						remove_add_(i+"_dayform_id_temp");
						remove_add_(i+"_monthform_id_temp");
						remove_add_(i+"_yearform_id_temp");
								break;
						}
				}	
		}
	}
	
	for(i=1; i<=form_view_max; i++)
	{
		if(document.getElementById('form_id_tempform_view'+i))
		{
			if(document.getElementById('page_next_'+i))
				document.getElementById('page_next_'+i).removeAttribute('src');
			if(document.getElementById('page_previous_'+i))
				document.getElementById('page_previous_'+i).removeAttribute('src');
			document.getElementById('form_id_tempform_view'+i).parentNode.removeChild(document.getElementById('form_id_tempform_view_img'+i));
			document.getElementById('form_id_tempform_view'+i).removeAttribute('style');
		}
	}
	
for(t=1;t<=form_view_max;t++)
{
	if(document.getElementById('form_id_tempform_view'+t))
	{
		form_view_element=document.getElementById('form_id_tempform_view'+t);		
		remove_whitespace(form_view_element);
		n=form_view_element.childNodes.length-2;
		
		for(q=0;q<=n;q++)
		{
				if(form_view_element.childNodes[q])
				if(form_view_element.childNodes[q].nodeType!=3)
				if(!form_view_element.childNodes[q].id)
				{
					del=true;
					GLOBAL_tr=form_view_element.childNodes[q];
					
					for (x=0; x < GLOBAL_tr.firstChild.childNodes.length; x++)
					{
			
						table=GLOBAL_tr.firstChild.childNodes[x];
						tbody=table.firstChild;
						
						if(tbody.childNodes.length)
							del=false;
					}
				
					if(del)
					{
						form_view_element.removeChild(form_view_element.childNodes[q]);
					}
				
				}
		}
	}	
}
	

	document.getElementById('form_front').value=document.getElementById('take').innerHTML;

}





	gen=<?php echo $row->counter; ?>;//add main form  id
    function enable()
	{
		alltypes=Array('customHTML','text','checkbox','radio','time_and_date','select','file_upload','captcha','map','button','page_break','section_break','paypal');
		for(x=0; x<13;x++)
		{
			document.getElementById('img_'+alltypes[x]).src="components/com_formmaker/images/"+alltypes[x]+".png";
		}
	
		if(document.getElementById('formMakerDiv').style.display=='block'){jQuery('#formMakerDiv').slideToggle(200);}else{jQuery('#formMakerDiv').slideToggle(400);}
		
		if(document.getElementById('formMakerDiv').offsetWidth)
			document.getElementById('formMakerDiv1').style.width	=(document.getElementById('formMakerDiv').offsetWidth - 60)+'px';
		
		if(document.getElementById('formMakerDiv1').style.display=='block'){jQuery('#formMakerDiv1').slideToggle(200);}else{jQuery('#formMakerDiv1').slideToggle(400);}
		document.getElementById('when_edit').style.display		='none';
	}

    function enable2()
	{
		alltypes=Array('customHTML','text','checkbox','radio','time_and_date','select','file_upload','captcha','map','button','page_break','section_break', 'paypal');
		for(x=0; x<13;x++)
		{
			document.getElementById('img_'+alltypes[x]).src="components/com_formmaker/images/"+alltypes[x]+".png";
		}
	
		if(document.getElementById('formMakerDiv').style.display=='block'){jQuery('#formMakerDiv').slideToggle(200);}else{jQuery('#formMakerDiv').slideToggle(400);}
		
		if(document.getElementById('formMakerDiv').offsetWidth)
			document.getElementById('formMakerDiv1').style.width	=(document.getElementById('formMakerDiv').offsetWidth - 60)+'px';
		
		if(document.getElementById('formMakerDiv1').style.display=='block'){jQuery('#formMakerDiv1').slideToggle(200);}else{jQuery('#formMakerDiv1').slideToggle(400);}
		document.getElementById('when_edit').style.display		='block';
		
		if(document.getElementById('field_types').offsetWidth)
			document.getElementById('when_edit').style.width	=document.getElementById('field_types').offsetWidth+'px';
		
		if(document.getElementById('field_types').offsetHeight)
			document.getElementById('when_edit').style.height	=document.getElementById('field_types').offsetHeight+'px';
		
	}
    </script>
<style>
#when_edit
{
position:absolute;
background-color:#666;
z-index:101;
display:none;
width:100%;
height:100%;
opacity: 0.7;
filter: alpha(opacity = 70);
}

#formMakerDiv
{
position:fixed;
background-color:#666;
z-index:100;
display:none;
left:0;
top:0;
width:100%;
height:100%;
opacity: 0.7;
filter: alpha(opacity = 70);
}
#formMakerDiv1
{
position:fixed;
z-index:100;
background-color:transparent;
top:0;
left:0;
display:none;
margin-left:30px;
margin-top:35px;
}

input[type="radio"], input[type="checkbox"] {
margin: 0px 4px 5px 5px;
}

.pull-left
{
float:none !important;
}

.modal-body
{
max-height:100%;
}

img
{
max-width:none;
}
.wdform_date
{
margin:0px !important;
}

.formmaker_table input
{
border-radius: 3px;
padding: 2px;
}

.formmaker_table
{
border-radius:8px;
border:6px #00aeef solid;
background-color:#00aeef;
height:120px;
}

.formMakerDiv1_table
{
border:6px #00aeef solid;
background-color:#FFF;
border-radius:8px;
}

</style>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div  class="formmaker_table" width="100%" >
<div style="float:left; text-align:center">
 	</br>
   <img src="components/com_formmaker/images/FormMaker.png" />
	</br>
	</br>
   <img src="components/com_formmaker/images/logo.png" />

</div>

<div style="float:right">

    <span style="font-size:16.76pt; font-family:tahoma; color:#FFFFFF; vertical-align:middle;">Form title:&nbsp;&nbsp;</span>

    <input id="title" name="title" style="width:151px; height:19px; border:none; font-size:11px; " value="<?php echo $row->title; ?>"/>
   <br/>
	<a href="#" onclick="Joomla.submitbutton('form_options_temp')" style="cursor:pointer;margin:10px; float:right; color:#fff; font-size:20px"><img src="components/com_formmaker/images/formoptions.png" /></a>    
   <br/>
	<img src="components/com_formmaker/images/addanewfield.png" onclick="enable(); Enable()" style="cursor:pointer;margin:10px; float:right" />

</div>
	
  

</div>
  
<div id="formMakerDiv" onclick="close_window()"></div>  
<div id="formMakerDiv1"  align="center">
    
    
<table border="0" width="100%" cellpadding="0" cellspacing="0" height="100%" class="formMakerDiv1_table">
  <tr>
    <td style="padding:0px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
        <tr valign="top">
         <td width="15%" height="100%" style="border-right:dotted black 1px;" id="field_types">
            <div id="when_edit" style="display:none"></div>
			<table border="0" cellpadding="0" cellspacing="3" width="100%" style="border-collapse: separate; border-spacing: 3px;">
			<tr>
            <td align="center" onClick="addRow('customHTML')" style="cursor:pointer" id="table_editor"  class="field_buttons"><img src="components/com_formmaker/images/customHTML.png" style="margin:5px" id="img_customHTML"/></td>
            
            <td align="center" onClick="addRow('text')" style="cursor:pointer" id="table_text" class="field_buttons"><img src="components/com_formmaker/images/text.png" style="margin:5px" id="img_text"/></td>
            </tr>
            <tr>
            <td align="center" onClick="addRow('time_and_date')" style="cursor:pointer" id="table_time_and_date" class="field_buttons"><img src="components/com_formmaker/images/time_and_date.png" style="margin:5px" id="img_time_and_date"/></td>
            
            <td align="center" onClick="addRow('select')" style="cursor:pointer" id="table_select" class="field_buttons"><img src="components/com_formmaker/images/select.png" style="margin:5px" id="img_select"/></td>
            </tr>
            <tr>             
            <td align="center" onClick="addRow('checkbox')" style="cursor:pointer" id="table_checkbox" class="field_buttons"><img src="components/com_formmaker/images/checkbox.png" style="margin:5px" id="img_checkbox"/></td>
            
            <td align="center" onClick="addRow('radio')" style="cursor:pointer" id="table_radio" class="field_buttons"><img src="components/com_formmaker/images/radio.png" style="margin:5px" id="img_radio"/></td>
            </tr>
            <tr>
            <td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" style="cursor:pointer" id="table_file_upload" class="field_buttons"><img src="components/com_formmaker/images/file_upload.png" style="margin:5px" id="img_file_upload"/></td>
            
            <td align="center" onClick="addRow('captcha')" style="cursor:pointer" id="table_captcha" class="field_buttons"><img src="components/com_formmaker/images/captcha.png" style="margin:5px" id="img_captcha"/></td>
            </tr>
            <tr>
            <td align="center" onClick="addRow('page_break')" style="cursor:pointer" id="table_page_break" class="field_buttons"><img src="components/com_formmaker/images/page_break.png" style="margin:5px" id="img_page_break"/></td>  
            
            <td align="center" onClick="addRow('section_break')" style="cursor:pointer" id="table_section_break" class="field_buttons"><img src="components/com_formmaker/images/section_break.png" style="margin:5px" id="img_section_break"/></td>
            </tr>
            <tr>
            <td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" id="table_map" class="field_buttons"><img src="components/com_formmaker/images/map.png" style="margin:5px" id="img_map"/></td>  
  			<td align="center" onClick="alert('This field type is disabled in free version. If you need this functionality, you need to buy the commercial version.')" id="table_paypal" class="field_buttons"><img src="components/com_formmaker/images/paypal.png" style="margin:5px" id="img_paypal" /></td>       
            </tr>		
			<tr>
            <td align="center" onClick="addRow('button')" id="table_button" class="field_buttons" colspan=2><img src="components/com_formmaker/images/button.png" style="margin:5px" id="img_button"/></td>
			
            </tr>
            </table>

         </td>
         <td width="35%" height="100%" align="left"><div id="edit_table" style="padding:0px; overflow-y:scroll; height:535px" ></div></td>

		 <td align="center" valign="top" style="background:url(components/com_formmaker/images/border2.png) repeat-y;">&nbsp;</td>
         <td style="padding:15px">
         <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
         
            <tr>
                <td align="right"><input type="radio" value="end" name="el_pos" checked="checked" id="pos_end" onclick="Disable()"/>
                  At The End
                  <input type="radio" value="begin" name="el_pos" id="pos_begin" onclick="Disable()"/>
                  At The Beginning
                  <input type="radio" value="before" name="el_pos" id="pos_before" onclick="Enable()"/>
                  Before
                  <select style="width:100px; margin-left:5px" id="sel_el_pos" disabled="disabled">
                  </select>
                  <img alt="ADD" title="add" style="cursor:pointer; vertical-align:middle; margin:5px" src="components/com_formmaker/images/save.png" onClick="add(0)"/>
                  <img alt="CANCEL" title="cancel"  style=" cursor:pointer; vertical-align:middle; margin:5px" src="components/com_formmaker/images/cancel_but.png" onClick="close_window()"/>
				
                	<hr style=" margin-bottom:10px" />
                  </td>
              </tr>
              
              <tr height="100%" valign="top">
                <td  id="show_table"></td>
              </tr>
              
            </table>
         </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<input type="hidden" id="old" />
<input type="hidden" id="old_selected" />
<input type="hidden" id="element_type" />
<input type="hidden" id="editing_id" />
<div id="main_editor" style="position:absolute; display:none; z-index:140;"><?php if($is_editor) echo $editor->display('editor','','440','350','40','6');
else
{
?>
<textarea name="editor" id="editor" cols="40" rows="6" style="width: 440px; height: 350px; " class="mce_editable" aria-hidden="true"></textarea>
<?php

}
 ?></div>
 </div>
 
 <?php if(!$is_editor)
?>
<iframe id="editor_ifr" style="display:none"></iframe>

<?php
?>


 
 
<br />
<br />

    <fieldset>

    <legend>

    <h2 style="color:#00aeef">Form</h2>

    </legend>

        <?php
		
    echo '<style>'.self::first_css.'</style>';

?>
<table width="100%" style="margin:8px"><tr id="page_navigation"><td align="center" width="90%" id="pages" show_title="<?php echo $row->show_title; ?>" show_numbers="<?php echo $row->show_numbers; ?>" type="<?php echo $row->pagination; ?>"></td><td align="left" id="edit_page_navigation"></td></tr></table>

    <div id="take">
    <?php
	
	    echo $row->form;
		
	 ?> </div>

    </fieldset>

    <input type="hidden" name="form" id="form">
    <input type="hidden" name="form_front" id="form_front">
    <input type="hidden" name="theme" id="theme" value="<?php echo $row->theme; ?>">
   
    <input type="hidden" name="pagination" id="pagination" />
    <input type="hidden" name="show_title" id="show_title" />
    <input type="hidden" name="show_numbers" id="show_numbers" />
	
    <input type="hidden" name="public_key" id="public_key" />
    <input type="hidden" name="private_key" id="private_key" />
    <input type="hidden" name="recaptcha_theme" id="recaptcha_theme" />

	<input type="hidden" id="label_order_current" name="label_order_current" value="<?php echo $row->label_order_current;?>" />
    <input type="hidden" id="label_order" name="label_order" value="<?php echo $row->label_order;?>" />
    <input type="hidden" name="counter" id="counter" value="<?php echo $row->counter;?>">

<script type="text/javascript">

function formOnload()
{
//enable maps
for(t=0; t<<?php echo $row->counter;?>; t++)
	if(document.getElementById(t+"_typeform_id_temp"))
	{
		if(document.getElementById(t+"_typeform_id_temp").value=="type_map" || document.getElementById(t+"_typeform_id_temp").value=="type_mark_map")
		{
			if_gmap_init(t);
			for(q=0; q<20; q++)
				if(document.getElementById(t+"_elementform_id_temp").getAttribute("long"+q))
				{
				
					w_long=parseFloat(document.getElementById(t+"_elementform_id_temp").getAttribute("long"+q));
					w_lat=parseFloat(document.getElementById(t+"_elementform_id_temp").getAttribute("lat"+q));
					w_info=parseFloat(document.getElementById(t+"_elementform_id_temp").getAttribute("info"+q));
					add_marker_on_map(t,q, w_long, w_lat, w_info, false);
				}
		}
		else
		if(document.getElementById(t+"_typeform_id_temp").value=="type_date")
				Calendar.setup({
						inputField: t+"_elementform_id_temp",
						ifFormat: document.getElementById(t+"_buttonform_id_temp").getAttribute('format'),
						button: t+"_buttonform_id_temp",
						align: "Tl",
						singleClick: true,
						firstDay: 0
						});

	}
	
	form_view=1;
	form_view_count=0;
	for(i=1; i<=30; i++)
	{
		if(document.getElementById('form_id_tempform_view'+i))
		{
			form_view_count++;
			form_view_max=i;
		}
	}
	
	if(form_view_count>1)
	{
		for(i=1; i<=form_view_max; i++)
		{
			if(document.getElementById('form_id_tempform_view'+i))
			{
				first_form_view=i;
				break;
			}
		}
		form_view=form_view_max;
		need_enable=false;
		
		generate_page_nav(first_form_view);
		
	var img_EDIT = document.createElement("img");
			img_EDIT.setAttribute("src", "components/com_formmaker/images/edit.png");
			img_EDIT.style.cssText = "margin-left:40px; cursor:pointer";
			img_EDIT.setAttribute("onclick", 'el_page_navigation()');
			
	var td_EDIT = document.getElementById("edit_page_navigation");
			td_EDIT.appendChild(img_EDIT);
	
	document.getElementById('page_navigation').appendChild(td_EDIT);

			
	}


//if(document.getElementById('take').innerHTML.indexOf('up_row(')==-1) location.reload(true);
//else 
document.getElementById('form').value=document.getElementById('take').innerHTML;
document.getElementById('araqel').value=1;

}

function formAddToOnload()
{ 
	if(formOldFunctionOnLoad){ formOldFunctionOnLoad(); }
	formOnload();
}

function formLoadBody()
{
	formOldFunctionOnLoad = window.onload;
	window.onload = formAddToOnload;
}

var formOldFunctionOnLoad = null;

formLoadBody();


</script>

    <input type="hidden" name="option" value="com_formmaker" />

    <input type="hidden" name="id" value="<?php echo $row->id?>" />

    <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />

    <input type="hidden" name="task" value="" />
    <input type="hidden" id="araqel" value="0" />

</form>
<script>
	appWidth			=parseInt(document.body.offsetWidth);
	appHeight			=parseInt(document.body.offsetHeight);
	
	jQuery('#modal-preview').on('show', function () {
document.getElementById('modal-preview-container').innerHTML = '<div class="modal-body"><iframe class="iframe" src="index.php?option=com_formmaker&task=preview&format=raw&theme='+document.getElementById('theme').value+'" height="'+(appHeight-200)+"px"+'" width="100%" style="border:0px"></iframe></div>';
});

document.getElementById('modal-preview').style.width=(appWidth-130)+"px";
document.getElementById('modal-preview').style.height=(appHeight-90)+"px";
document.getElementById('modal-preview').style.left="50px";
document.getElementById('modal-preview').style.top="30px";
document.getElementById('modal-preview').style.margin="0px";
</script>

<?php		
$bar=& JToolBar::getInstance( 'toolbar' );
$bar->appendButton( 'popup', 'preview', 'Preview', 'index.php?option=com_formmaker&task=preview&format=raw', '617', '500' );

       }	

	


/////////////////////////////////////////////////////////////////////// THEME /////////////////////////////////



function show_themes(&$rows, &$pageNav, &$lists){

JSubMenuHelper::addEntry(JText::_('Forms'), 'index.php?option=com_formmaker&amp;task=forms' );
JSubMenuHelper::addEntry(JText::_('Submissions'), 'index.php?option=com_formmaker&amp;task=submits' );
JSubMenuHelper::addEntry(JText::_('Themes'), 'index.php?option=com_formmaker&amp;task=themes', true );

		JHTML::_('behavior.tooltip');	

	?>
<script type="text/javascript">
Joomla.tableOrdering= function ( order, dir, task )  {
    var form = document.adminForm;
    form.filter_order_themes.value     = order;
    form.filter_order_Dir_themes.value = dir;
    submitform( task );
}

function isChecked(isitchecked){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
	}
	else {
		document.adminForm.boxchecked.value--;
	}
}

</script>
	
   
	<form action="index.php?option=com_formmaker" method="post" name="adminForm" id="adminForm">
    
		<table width="100%">
		<tr>
			<td align="left" width="100%">
				<input type="text" name="search_theme" id="search_theme" value="<?php echo $lists['search_theme'];?>" class="text_area"  placeholder="Search theme" style="margin:0px" />
				<button class="btn tip hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('search_theme').value='';this.form.submit();" data-original-title="Clear">
				<i class="icon-remove"></i></button>
				
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $pageNav->getLimitBox(); ?>
				</div>

			</td>
		</tr>
		</table>    
    
        
    <table class="table table-striped"  width="100%">
    <thead>
    	<tr>            
            <th width="30" class="title"><?php echo "#" ?></td>
            <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>)"></th>
            <th width="30" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></td>
            <th><?php echo JHTML::_('grid.sort', 'Title', 'title', @$lists['order_Dir'], @$lists['order'] ); ?></th>
            <th><?php echo JText::_('Default'); ?></th>
        </tr>
    </thead>
	<tfoot>
		<tr>
			<td colspan="11">
			 <?php echo $pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
                
    <?php
    $k = 0;
	for($i=0, $n=count($rows); $i < $n ; $i++)
	{
		$row = &$rows[$i];
		$checked 	= JHTML::_('grid.id', $i, $row->id);
		$link 		= JRoute::_( 'index.php?option=com_formmaker&task=edit_themes&cid[]='. $row->id );
?>
        <tr class="<?php echo "row$k"; ?>">
        	<td align="center"><?php echo $i+1?></td>
        	<td><?php echo $checked?></td>
        	<td align="center"><?php echo $row->id?></td>
        	<td><a href="<?php echo $link;?>"><?php echo $row->title?></a></td>            
			<td align="center">
				<?php if ( $row->default == 1 ) : ?>
				<i class="icon-star"></i>
				<?php else : ?>
				&nbsp;
				<?php endif; ?>
			</td>
       </tr>
        <?php
		$k = 1 - $k;
	}
	?>
    </table>
	
    <input type="hidden" name="option" value="com_formmaker">
    <input type="hidden" name="task" value="themes">    
    <input type="hidden" name="boxchecked" value="0"> 
    <input type="hidden" name="filter_order_themes" value="<?php echo $lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir_themes" value="<?php echo $lists['order_Dir']; ?>" />       
    </form>

<?php
}

function add_themes($def_theme){

		JRequest::setVar( 'hidemainmenu', 1 );
		
		?>
        
<script>

Joomla.submitbutton= function (pressbutton) {
	
	var form = document.adminForm;
	
	if (pressbutton == 'cancel_themes') 
	{
		submitform( pressbutton );
		return;
	}
	if(form.title.value=="")
	{
		alert('Set Theme title');
		return;
	}

	submitform( pressbutton );
}


</script>        
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
<table class="admintable" >

 
				<tr>
					<td class="key">
						<label for="title">
							Title of theme:
						</label>
					</td>
					<td >
                                    <input type="text" name="title" id="title" size="80"/>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="title">
							Css:
						</label>
					</td>
					<td >
                                    <textarea name="css" id="css" rows=30 style="width:500px"><?php echo $def_theme->css ?></textarea>
					</td>
				</tr>
</table>           
    <input type="hidden" name="option" value="com_formmaker" />
    <input type="hidden" name="task" value="" />
</form>

	   <?php	
	
}


function edit_themes(&$row){

		JRequest::setVar( 'hidemainmenu', 1 );
		
		?>
        
<script>

Joomla.submitbutton= function (pressbutton) {
	
	var form = document.adminForm;
	
	if (pressbutton == 'cancel_themes') 
	{
		submitform( pressbutton );
		return;
	}
	if(form.title.value=="")
	{
		alert('Set Theme title');
		return;
	}

	submitform( pressbutton );
}


</script>        
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
<table class="admintable" >

 
				<tr>
					<td class="key">
						<label for="title">
							Title of theme:
						</label>
					</td>
					<td >
                        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($row->title) ?>" size="80"/>
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="title">
							Css:
						</label>
					</td>
					<td >
                        <textarea name="css" id="css" rows=30 style="width:500px"><?php echo htmlspecialchars($row->css) ?></textarea>
					</td>
				</tr>
</table>           
    <input type="hidden" name="option" value="com_formmaker" />
	<input type="hidden" name="id" value="<?php echo $row->id?>" />        
	<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />        
	<input type="hidden" name="task" value="" />        
</form>

	   <?php	
	
}

/////////////////////////////////////////////////////////////////////// THEME /////////////////////////////////










	
function editSubmit($rows, $labels_id ,$labels_name,$labels_type){
JRequest::setVar( 'hidemainmenu', 1 );
$editor	=& JFactory::getEditor();
		?>
        
<script language="javascript" type="text/javascript">

Joomla.submitbutton= function (pressbutton) {
	var form = document.adminForm;

	if (pressbutton == 'cancel_submit') 
	{
	submitform( pressbutton );
	return;
	}

	submitform( pressbutton );
}

</script>        

<form action="index.php" method="post" name="adminForm"  id="adminForm">
<table class="admintable" style="border-spacing:5px; border-collapse: separate;">
				<tr>
					<td class="key">
						<label for="ID">
							<?php echo JText::_( 'ID' ); ?>:
						</label>
					</td>
					<td >
                       <?php echo $rows[0]->group_id;?>
					</td>
				</tr>
                
                <tr>
					<td class="key">
						<label for="Date">
							<?php echo JText::_( 'Date' ); ?>:
						</label>
					</td>
					<td >
                       <?php echo $rows[0]->date;?>
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="IP">
							<?php echo JText::_( 'IP' ); ?>:
						</label>
					</td>
					<td >
                       <?php echo $rows[0]->ip;?>
					</td>
                </tr>
                
<?php 
foreach($labels_id as $key => $label_id)
{
	if($labels_type[$key]!='' and $labels_type[$key]!='type_editor' and $labels_type[$key]!='type_submit_reset' and $labels_type[$key]!='type_map' and $labels_type[$key]!='type_mark_map' and $labels_type[$key]!='type_captcha' and $labels_type[$key]!='type_recaptcha' and $labels_type[$key]!='type_button')
	{
		$element_value='';
		foreach($rows as $row)
		{
			if($row->element_label==$label_id)
			{		
				$element_value=	$row->element_value;
				break;
			}
		}
		
		switch ($labels_type[$key])
		{
			case 'type_checkbox':
			{
			$choices	= explode('***br***',$element_value);
			$choices 	= array_slice($choices,0, count($choices)-1);   
		echo '		<tr>
						<td class="key" rowspan="'.count($choices).'">
							<label for="title">
								'.$labels_name[$key].'
							</label>
						</td>';
			foreach($choices as $choice_key => $choice)
		echo '
						<td >
							<input type="text" name="submission_'.$label_id.'_'.$choice_key.'" id="submission_'.$label_id.'_'.$choice_key.'" value="'.$choice.'" size="80" />
						</td>
					</tr>
					';
				
			break;
			}
			case 'type_paypal_payment_status':
			{
			echo '		<tr>
							<td class="key">
								<label for="title">
									'.$labels_name[$key].'
								</label>
							</td>
							<td >'
							
							?>
							
<select name="submission_0" id="submission_0" >
	<option value="" ></option>
	<option value="Canceled" >Canceled</option>
	<option value="Cleared" >Cleared</option>
	<option value="Cleared by payment review" >Cleared by payment review</option>
	<option value="Completed" >Completed</option>
	<option value="Denied" >Denied</option>
	<option value="Failed" >Failed</option>
	<option value="Held" >Held</option>
	<option value="In progress" >In progress</option>
	<option value="On hold" >On hold</option>
	<option value="Paid" >Paid</option>
	<option value="Partially refunded" >Partially refunded</option>
	<option value="Pending verification" >Pending verification</option>
	<option value="Placed" >Placed</option>
	<option value="Processing" >Processing</option>
	<option value="Refunded" >Refunded</option>
	<option value="Refused" >Refused</option>
	<option value="Removed" >Removed</option>
	<option value="Returned" >Returned</option>
	<option value="Reversed" >Reversed</option>
	<option value="Temporary hold" >Temporary hold</option>
	<option value="Unclaimed" >Unclaimed</option>
</select>	
<script> 
    var element = document.getElementById('submission_0');
    element.value = '<?php echo $element_value; ?>';
</script>
							
							<?php
							echo '
							</td>
						</tr>
						';

			
			break;
			}
			default:
			{
			echo '		<tr>
							<td class="key">
								<label for="title">
									'.$labels_name[$key].'
								</label>
							</td>
							<td >
								<input type="text" name="submission_'.$label_id.'" id="submission_'.$label_id.'" value="'.str_replace("*@@url@@*",'',$element_value).'" size="80" />
							</td>
						</tr>
						';

			}
			break;
		}

		
	}
}

?>
 </table>        
<input type="hidden" name="option" value="com_formmaker" />
<input type="hidden" name="id" value="<?php echo $rows[0]->group_id?>" />        
<input type="hidden" name="form_id" value="<?php echo $rows[0]->form_id?>" />        
<input type="hidden" name="date" value="<?php echo $rows[0]->date?>" />        
<input type="hidden" name="ip" value="<?php echo $rows[0]->ip?>" />        
<input type="hidden" name="task" value="save_submit" />        
</form>
        <?php		
       

}
	   
	   
	   
function forchrome($id){
?>
<script type="text/javascript">


window.onload=val; 

function val()
{
var form = document.adminForm;
	submitform();
}

</script>
<form action="index.php" method="post" name="adminForm"  id="adminForm">

    <input type="hidden" name="option" value="com_formmaker" />

    <input type="hidden" name="id" value="<?php echo $id;?>" />

    <input type="hidden" name="cid[]" value="<?php echo $id; ?>" />

    <input type="hidden" name="task" value="gotoedit" />
</form>
<?php
}


function select_article(&$rows, &$pageNav, &$lists)
{



		JHTML::_('behavior.tooltip');	

	?>

<form action="index.php?option=com_formmaker" method="post" name="adminForm" id="adminForm">

    <table width="100%">

        <tr>

            <td align="left" width="100%"> <?php echo JText::_( 'Filter' ); ?>:

                <input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />

                <button onclick="this.form.submit();"> <?php echo JText::_( 'Go' ); ?></button>

                <button onclick="document.getElementById('search').value='';this.form.submit();"> <?php echo JText::_( 'Reset' ); ?></button>

            </td>

        </tr>

    </table>

    <table class="adminlist" width="100%">

        <thead>

            <tr>

                <th width="4%"><?php echo '#'; ?></th>

                <th width="8%">

                    <input type="checkbox" name="toggle"

 value="" onclick="checkAll(<?php echo count($rows)?>)">

                </th>

                <th width="50%"><?php echo JHTML::_('grid.sort', 'Title', 'title', @$lists['order_Dir'], @$lists['order'] ); ?></th>

                <th width="38%"><?php echo JHTML::_('grid.sort', 'Email to send submissions to', 'mail', @$lists['order_Dir'], @$lists['order'] ); ?></th>

            </tr>

        </thead>

        <tfoot>

            <tr>

                <td colspan="50"> <?php echo $pageNav->getListFooter(); ?> </td>

            </tr>

        </tfoot>

        <?php

	

    $k = 0;

	for($i=0, $n=count($rows); $i < $n ; $i++)

	{

		$row = &$rows[$i];

		$checked 	= JHTML::_('grid.id', $i, $row->id);

		$published 	= JHTML::_('grid.published', $row, $i); 

		// prepare link for id column

		$link 		= JRoute::_( 'index.php?option=com_formmaker&task=edit&cid[]='. $row->id );

		?>

        <tr class="<?php echo "row$k"; ?>">

              <td align="center"><?php echo $row->id?></td>

          <td align="center"><?php echo $checked?></td>

            <td align="center"><a href="<?php echo $link; ?>"><?php echo $row->title?></a></td>

            <td align="center"><?php echo $row->mail?></td>

        </tr>

        <?php

		$k = 1 - $k;

	}

	?>

    </table>

    <input type="hidden" name="option" value="com_formmaker">
    <input type="hidden" name="task" value="forms">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />

</form>

<?php

}







//////////////////////////////glxavor 
}
?>

