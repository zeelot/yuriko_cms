<?php
/**
 * content/static/admin/nodes/delete.php
 */
?>
<div>
	<p class="notice">
	Are you sure you want to delete this Node?
	All the Pages that use this Node will automatically remove it and you
	will have to edit the Pages even if you recreate this Node.
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
