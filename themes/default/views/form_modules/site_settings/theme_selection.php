<!-- START THEME SELECTION MODULE -->
	<fieldset>
        <legend>Site Theme</legend>
        <select name="site_theme">
            <?php foreach($themes as $theme): ?>
            <option value="<?php echo $theme; ?>" <?php echo ($sel == $theme)? 'selected="selected"':NULL; ?>><?php echo $theme; ?></option>
            <?php endforeach; ?>
        </select>
    </fieldset>
<!-- END THEME SELECTION MODULE -->