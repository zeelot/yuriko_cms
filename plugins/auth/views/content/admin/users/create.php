
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>New User</legend>
		<input type="hidden" name="new_user" value="TRUE" />
		<label>Username: <input name="username" type="text" value="<?php echo $user->username; ?>" /></label>
		<label>Password: <input name="password" type="password" /></label>
		<label>Repeat Password: <input name="password_confirm" type="password" /></label>
		<label>E-Mail: <input name="email" type="text" value="<?php echo $user->email; ?>" /></label>
		<label><button>Create</button></label>
	</fieldset>
<?php echo form::close(); ?>
</div>