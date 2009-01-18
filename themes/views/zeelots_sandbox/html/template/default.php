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
			<h1>Theme Test</h1>
        </div>
        <div class="grid_16">
			<?php echo widget::get('theme'); ?>
            <?php echo (isset($content))? $content : null; ?>
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
			<h3>Message from Zeelot's Sandbox Theme!</h3>
			<p>
			Here is another example of how much control you have over the
			content in a Theme. The structure of the HTML in this theme is
			completely different from the Default theme . The views that are
			loaded however are actually recycled from the Default theme!
			</p>
			<p>
			There is no reason to rewrite the HTML for the theme form so it
			isn't added to this theme as a View, instead it is taken from the
			Default theme because I didn't create a new version for it.
			The View for the Welcome message is also taken
			from the Default theme no matter which theme you load...DRY!
			The only Views being rewritten for all three themes are the template
			Views to restructure the HTML.  Obviously a few more files would need
			to be rewritten on a regular site.
			</p>
			<p><strong>Thanks for using Zeelot's Sandbox Theme!</strong></p>
        </div>
		<div class="clear"></div>
    </div>
</body>
</html>