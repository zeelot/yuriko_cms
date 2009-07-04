
	<?php echo form::open(); ?>
	<fieldset>
		<legend>Continue with Action?</legend>
		<?php if (isset($message)): ?>
		<p class="notice"><?php echo $message; ?></p>
		<?php endif; ?>
		<button type="submit" name="confirm" value="confirm">Confirm</button>
		<button type="submit" name="cancel" value="cancel">Cancel</button>
	</fieldset>
	<?php echo form::close(); ?>