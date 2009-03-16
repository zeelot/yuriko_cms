
<!-- START LOGIN FORM -->
<?php echo form::open(); ?>
    <fieldset>
        <legend>Login</legend>
		<input type="hidden" name="login_form" value="TRUE" />
		<label for="username">Username: <input id="username" type="text" name="username" /></label>
		<label for="password">Password: <input id="password" type="password" name="password" /></label>
        <button name="Submit" type="submit" value="Submit">Login</button>
    </fieldset>
<?php echo form::close(); ?>
<!-- END LOGIN FORM -->