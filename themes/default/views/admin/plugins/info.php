
<div>
	<h1><?php echo $plugin->name; ?></h1>
	<p><strong>Description: </strong><?php echo $plugin->description; ?></p>
	<ul>
		<li><strong>Version:</strong> <?php echo $plugin->version; ?></li>
		<li><strong>Directory:</strong> <?php echo $plugin->dir; ?></li>
		<?php foreach($plugin->dependencies as $dependency => $version): ?>
		<li><strong>Required:</strong> <?php echo $dependency; ?> version <?php echo $version; ?></li>
		<?php endforeach; ?>
	</ul>
</div>