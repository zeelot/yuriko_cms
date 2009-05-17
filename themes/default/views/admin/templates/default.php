<?php
/*
 *
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo assets::all(); ?>

<title>Admin Panel!</title>
</head>

<body>
    <div class="container_16" id="main_frame">
		<div class="grid_16">
			<?php echo notice::render(); ?>
		</div>
        <div class="grid_4 side_panel">
			<?php echo View::factory('admin/nav/main'); ?>
        </div>
        <div class="grid_12 content">
            <?php echo (isset($content))? $content : null; ?>
        </div>
		<div class="clear"></div>
    </div>
</body>
</html>