<?php

?>

<!-- START THEME SELECTION FORM -->
<?php echo form::open(); ?>
	<input type="hidden" name="theme_selection_form" value="TRUE" />
    <fieldset>
		<?php if($changed): ?>
		<div class="success">Theme Set Successfully!</div>
		<?php endif; ?>
        <legend>Change Theme</legend>
        <select name="theme">
            <?php foreach($themes as $theme): ?>
            <option value="<?php echo $theme['name']; ?>" <?php echo ($theme['name'] == $active['name'])? 'selected="selected"' : null; ?>><?php echo $theme['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <button name="Submit" type="submit" value="Submit">Submit</button>
    </fieldset>
<?php echo form::close(); ?>
<!-- END THEME SELECTION FORM -->