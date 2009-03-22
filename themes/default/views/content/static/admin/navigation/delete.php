
<div>
	<p class="notices notice">
	Are you sure you want to delete this Item and all of it's children?
	This action cannot be undone! Deleting this Item will automatically remove
	any Navigation content related to this Item from any Pages.
	</p>
	<?php echo form::open(); ?>
	<fieldset>
		<legend>Continue with Action?</legend>
		<button type="submit" name="confirm" value="confirm">Confirm</button>
		<button type="submit" name="cancel" value="cancel">Cancel</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>
