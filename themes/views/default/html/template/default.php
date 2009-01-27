<?php
/*
 *
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php assets::get_stylesheets(FALSE, 'global', TRUE); ?>
<?php assets::get_stylesheets(FALSE, '960_framework', TRUE); ?>
<?php assets::get_stylesheets(FALSE, 'global_typography', TRUE); ?>

<?php assets::get_scripts(FALSE, 'global', TRUE); ?>

<?php echo html::stylesheet('themes/views/'.$theme['dir'].'/styles'); ?>
<title>Zeelot's Special Sandbox!</title>
</head>

<body>
    <div class="container_16" id="main_frame">
		<div class="grid_16">
			<?php echo notice::render(); ?>
		</div>
        <div class="grid_4">
			<?php echo View::factory('menu/main'); ?>
			<?php echo widget::get('user_info'); ?>
			<p>
				<a href="http://validator.w3.org/check?uri=referer" class="noicon">
				<img
					src="http://www.w3.org/Icons/valid-xhtml10"
					alt="Valid XHTML 1.0 Transitional" />
				</a>
			</p>
			<p>
				<a href="http://jigsaw.w3.org/css-validator" class="noicon">
				<img
					src="http://jigsaw.w3.org/css-validator/images/vcss"
					alt="Valid CSS!" />
				</a>
			</p>
        </div>
        <div class="grid_12">
            <?php echo (isset($content))? $content : null; ?>
        </div>
		<div class="clear"></div>
    </div>
</body>
</html>