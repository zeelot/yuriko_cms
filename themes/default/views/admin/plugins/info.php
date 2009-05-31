
<div class="yuriko_plugin_info">
	<h1><?php echo $plugin->name; ?></h1>
	<div class="description"><?php echo $description; ?></div>
	<ul>
		<li><strong>Version:</strong> <?php echo $plugin->version; ?></li>
		<li><strong>Directory:</strong> <?php echo $plugin->dir; ?></li>
		<?php foreach($plugin->dependencies as $dependency => $version): ?>
		<?php if (sizeof($version) == 1): ?>
		<li><strong>Required:</strong>
			<?php echo $dependency; ?> version <?php echo $version[0]; ?></li>
		<?php elseif (sizeof($version) == 2): ?>
		<li><strong>Required:</strong>
			<?php echo $dependency; ?> versions <?php echo $version[0]; ?> to <?php echo $version[1]; ?></li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>