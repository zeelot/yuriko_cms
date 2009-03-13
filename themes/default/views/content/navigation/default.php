<div class="navigation">
	<?php if(!$node->anchor): ?>
	<h2><?php echo $node->name; ?></h2>
	<?php else: ?>
	<?php echo html::anchor($node->anchor, $node->name); ?>
	<?php endif; ?>
	<ul>
		<?php foreach($node->children as $child): ?>
			<li><?php echo $child->render(); ?></li>
		<?php endforeach; ?> 
	</ul>
</div>
