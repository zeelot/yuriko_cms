<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo assets::all(); ?>

<title>YurikoCMS</title>
</head>

<body>
    <div class="container_16 frontend" id="main_frame">
		<div class="grid_16">
			<?php echo html::image('themes/yuriko_cms/media/images/yuriko_logo.png'); ?>
			<?php echo notice::render(); ?> 
		</div>
		<!-- BEGIN SECTION -->
		<div class="grid_16 section header">
			 <?php foreach(section::get('Header') as $node): ?>
				<?php echo $node; ?>
			<?php endforeach; ?>
		</div>
		<!-- END SECTION -->
		<!-- BEGIN SECTION -->
		<div class="grid_12 section content">
			<?php foreach(section::get('Main Content') as $node): ?>
				<?php echo $node; ?>
			<?php endforeach; ?>
		</div>
		<!-- END SECTION -->
		<!-- BEGIN SECTION -->
		<div class="grid_4 section side_panel">
			<?php foreach(section::get('Side Panel') as $node): ?>
				<?php echo $node; ?>
			<?php endforeach; ?>
		</div>
		<!-- END SECTION -->
		<!-- BEGIN SECTION -->
		<div class="grid_16 section gutter">
			<?php foreach(section::get('Gutter') as $node): ?>
				<?php echo $node; ?>
			<?php endforeach; ?>
		</div>
		<!-- END SECTION -->
		<div class="clear"></div>
    </div>
</body>
</html>