<div class="profile message">
    <h1>Profile</h1>
	<?php echo form::open(NULL, array('autocomplete' => 'off')); ?>
	<input type="hidden" name="profile_form" value="TRUE" />
    <fieldset>
        <legend>Settings</legend>
		<label for="password">New Password: <input type="password" name="password" /></label>
		<label for="password_confirm">Confirm Password: <input type="password" name="password_confirm" /></label>
    </fieldset>
	<fieldset>
        <legend>Theme</legend>
        <select name="theme_id">
            <?php foreach($themes as $theme): ?>
            <option value="<?php echo $theme->id; ?>" <?php echo ($theme->id == $user->profile->theme->id)? 'selected="selected"' : null; ?>><?php echo $theme->name; ?></option>
            <?php endforeach; ?>
        </select>
    </fieldset>
	<fieldset>
        <legend>Information</legend>
		<label for="name">Name: <input type="text" name="name" value="<?php echo $user->profile->name; ?>" /></label>
		<label for="location">Location: <input type="text" name="location" value="<?php echo $user->profile->location; ?>" /></label>
    </fieldset>
	<fieldset>
        <legend>Contact</legend>
		<label for="email">E-Mail: <input type="text" name="email" value="<?php echo $user->profile->email; ?>" /></label>
		<label for="msn">MSN: <input type="text" name="msn" value="<?php echo $user->profile->msn; ?>" /></label>
		<label for="yahoo">Yahoo: <input type="text" name="yahoo" value="<?php echo $user->profile->yahoo; ?>" /></label>
		<label for="aim">AIM: <input type="text" name="aim" value="<?php echo $user->profile->aim; ?>" /></label>
		<label for="skype">Skype: <input type="text" name="skype" value="<?php echo $user->profile->skype; ?>" /></label>
    </fieldset>
	<button name="Save" value="Save" type="submit">Save</button>
	<?php echo form::close(); ?>
</div>