
<div>
	<p class="notice">
	Are you sure you want to delete this Content?
	This action cannot be undone!
	</p>
	<?php echo form::open(); ?>
	<fieldset>
		<legend>Continue with Action?</legend>
		<button type="submit" name="confirm" value="confirm">Confirm</button>
		<button type="submit" name="cancel" value="cancel">Cancel</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>
