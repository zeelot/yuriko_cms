<?php
/**
 * content/static/admin/navigation/delete.php
 */
?>
<div>
	<p class="notice">
	Are you sure you want to delete this Item and all of it's children?
	This action cannot be undone! Deleting this Item will automatically remove
	any Navigation content related to this Item from any Pages.
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
