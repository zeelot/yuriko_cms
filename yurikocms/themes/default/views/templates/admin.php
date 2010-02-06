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
		<div class="grid_16 section header">
			<?php echo html::image('yurikocms/themes/default/media/images/yuriko_logo.png', array('alt' => 'YurikoCMS')); ?>
		</div>
		<div class="grid_16">
			<div class="grid_12 alpha">
				<h1><?php echo $title; ?></h1>
				<?php echo isset($content)? $content : NULL; ?>
			</div>
			<div class="grid_4 omega">
				<h3>Navigation</h3>
				<?php Event::run('yuriko.admin.navigation.render', $navigation); ?>
				<?php echo $navigation; ?>
			</div>
		</div>
		<div class="clear"></div>
    </div>
</body>
</html>