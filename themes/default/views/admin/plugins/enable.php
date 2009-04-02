<?php
/**
 * content/static/admin/plugins/enable.php
 */
?>
<div>
	<p class="notice">
	<?php echo $plugin->notice_enable; ?>
	</p>
	<?php echo View::factory('forms/simple_confirmation'); ?>
</div>
