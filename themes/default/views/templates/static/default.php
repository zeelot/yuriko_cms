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
		<div class="grid_16">
			<?php echo (isset($content))? $content : null; ?>
		</div>
		<div class="clear"></div>
    </div>
</body>