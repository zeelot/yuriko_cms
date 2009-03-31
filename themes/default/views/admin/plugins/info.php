<?php
/**
 * This view should use $plugin as an array
 */
?>
<div>
	<h1><?php echo $plugin['name']; ?></h1>
	<p><strong>Description: </strong><?php echo $plugin['description']; ?></p>
	<ul>
		<li><strong>Version:</strong> <?php echo $plugin['version']; ?></li>
		<li><strong>Directory:</strong> <?php echo $plugin['dir']; ?></li>
	</ul>
</div>