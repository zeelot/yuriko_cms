
<!-- START LOGIN FORM -->
<?php echo form::open(); ?>
    <fieldset>
        <legend>Login</legend>
		<input type="hidden" name="login_form" value="TRUE" />
		<label for="username">Username: <input type="text" name="username" /></label>
		<label for="password">Password: <input type="password" name="password" /></label>
		<label for="remember"><input type="checkbox" name="remember" />Remember Me.</label>
        <button name="Submit" type="submit" value="Submit">Login</button>
    </fieldset>
<?php echo form::close(); ?>
<!-- END LOGIN FORM -->