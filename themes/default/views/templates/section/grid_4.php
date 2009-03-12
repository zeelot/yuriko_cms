<div class="grid_4 section">
	<h2><?php echo $section->name; ?></h2>
	<?php foreach($nodes as $node): ?>
	<?php echo View::factory($node->template)->set('node', $node); ?>
	<?php endforeach; ?>
</div>