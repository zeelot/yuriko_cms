<?php
/**
 * admin/users/delete.php
 */
?>
<div>
	<p class="notice">
	Are you sure you want to delete this User?
	This action cannot be undone!
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
