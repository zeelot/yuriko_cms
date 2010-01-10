<?php
/**
 * Default Admin Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo Assets::instance()->render(); ?>
<title>Default Theme - <?php echo $title; ?></title>
</head>

<body>
    <div class="container_16" id="main_frame">
		<!-- BEGIN SECTION -->
		<div class="grid_16 section header">
			<?php echo html::image('yurikocms/themes/default/media/images/yuriko_logo.png', array('alt' => 'YurikoCMS')); ?>
		</div>
		<!-- END SECTION -->
		<div class="grid_16">
			<?php echo isset($content)? $content : NULL; ?>
		</div>
		<div class="clear"></div>
    </div>
</body>
</html>