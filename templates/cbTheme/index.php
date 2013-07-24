<?php
/**
 * @version 1.0.0
 * @package templates
 * @subpackage coding booth
 * @copyright (C) 2013 Coding Booth. All rights reserved.
 * @author carlospaiva
 * @license GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/styles.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Add current user information
$user = JFactory::getUser();

// Logo file or site title param
if ($this->params->get('logo'))
{
	$logo = '<img src="'. JURI::root() . $this->params->get('logo') .'" class="logo" alt="'. $sitename .'" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. htmlspecialchars($this->params->get('sitetitle')) .'</span>';
}
else
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. $sitename .'</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">

	<!-- Body -->
	<div class="body">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '');?>">
			<!-- Header -->
			<div class="header container-fluid">
				<a href="<?php echo $this->baseurl; ?>" class="span6 logolink">
					<?php echo $logo;?>
				</a>
				<jdoc:include type="modules" name="menus" style="none" />
			</div>
			<jdoc:include type="modules" name="banner" style="xhtml" />
			<div class="row-fluid">
				<div id="content" class="span12">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="content" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" style="xhtml" />
					<!-- End Content -->
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<div class="footer">
		<?php if ($this->countModules('footer')) : ?>
			<div class="container-fluid">
				<div class="span6">
					<!-- Begin Right Sidebar -->
					<jdoc:include type="modules" name="footer" style="well" />
					<!-- End Right Sidebar -->
				</div>
				<div class="span6">
					<p>&copy; <?php echo date('Y');?> <?php echo $sitename; ?> - All Rights Reserved - Design by <a href="graphicboost.org" target="_blank">Graphic Boost</a></p>
				</div>
			</div>
		<?php else : ?>
			<div class="container-fluid">
				<div class="span12">
					<p>&copy; <?php echo date('Y');?> <?php echo $sitename; ?> - All Rights Reserved - Design by <a href="http://graphicboost.org" target="_blank">Graphic Boost</a></p>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
