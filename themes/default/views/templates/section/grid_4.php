
<!-- BEGIN SECTION -->
<div class="grid_4 section">
	<?php foreach($nodes as $node): ?>
	<?php echo View::factory($node->template)->set('node', $node->find_content()); ?>
	<?php endforeach; ?>
</div>
<!-- END SECTION -->