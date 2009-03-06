<!-- START THEME SELECTION MODULE -->
	<fieldset>
        <legend>Theme</legend>
        <select name="theme_id">
            <?php foreach($themes as $theme): ?>
            <option value="<?php echo $theme->id; ?>" <?php echo ($theme->id == $user->profile->theme->id)? 'selected="selected"' : null; ?>><?php echo $theme->name; ?></option>
            <?php endforeach; ?>
        </select>
    </fieldset>
<!-- END THEME SELECTION MODULE -->