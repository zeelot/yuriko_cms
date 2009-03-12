<div class="section">
	<?php foreach($nodes as $node): ?>
	<?php echo View::factory($node->template)->set('node', $node); ?>
	<?php endforeach; ?>
</div>