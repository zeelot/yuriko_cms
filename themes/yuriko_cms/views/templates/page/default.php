<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo assets::all(); ?>

<title>Zeelot's Special Sandbox!</title>
</head>

<body>
	<div id="header"></div>
	<div id="content_container">
		<div class="container_16" id="main_frame">
			<div class="grid_16">
				<?php echo notice::render(); ?>
			</div>
			<?php echo $content; ?>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>