<?php
/**
 * content/static/admin/pages/delete.php
 */
?>
<div>
	<p class="notice">
	Are you sure you want to delete this Page? All the content in the page
	will not be deleted but you will have to reassign it to the Page if you
	decide to recreate it.
	This action cannot be undone!
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
