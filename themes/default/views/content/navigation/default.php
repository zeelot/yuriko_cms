<div class="navigation">
	<h2><?php echo $node->name; ?></h2>
	<?php $level = $node->level; ?>
	<?php foreach($node->subtree()->find_all() as $child): ?>
		<?php if($child->level > $level): ?>
		<ul><li><?php echo $child->name; ?>
		<?php $level++; ?>
		<?php elseif($child->level < $level): ?>
		<?php echo str_repeat('</li></ul>', $child->level < $level); ?><li><?php echo $child->name; ?>
		<?php $level = $child->level; ?>
		<?php else: ?>
		</li><li><?php echo $child->name; ?> 
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>
