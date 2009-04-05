
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit <?php echo $user->username; ?></legend>
		<input type="hidden" name="edit_user" value="TRUE" />
		<input type="hidden" name="username" value="<?php echo $user->username; ?>" />
		<label>New Password: <input name="password" type="password" /></label>
		<label>Repeat Password: <input name="password_confirm" type="password" /></label>
		<label>E-Mail: <input name="email" type="text" value="<?php echo $user->email; ?>" /></label>
		<label><button>Save</button></label>
	</fieldset>
<?php echo form::close(); ?>
</div>