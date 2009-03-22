
<div>
	<p class="notice">
	Are you sure you want to delete this Node?
	All the Pages that use this Node will automatically remove it and you
	will have to edit the Pages even if you recreate this Node.
	</p>
	<?php echo form::open(); ?>
	<fieldset>
		<legend>Continue with Action?</legend>
		<button type="submit" name="confirm" value="confirm">Confirm</button>
		<button type="submit" name="cancel" value="cancel">Cancel</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>
