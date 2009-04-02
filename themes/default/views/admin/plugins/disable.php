<?php
/**
 * content/static/admin/plugins/disable.php
 */
?>
<div>
	<p class="notice">
	<?php echo $plugin->notice_disable; ?>
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
