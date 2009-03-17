<div class="navigation">
	<h2><?php echo $node->name; ?></h2>
	<?php $level = $node->level; ?>
	<?php foreach($node->subtree()->find_all() as $child): ?>
		<?php if($child->level > $level): ?> 
	<div><ul>
		<li>
		<?php $level++; ?> 
		<?php elseif($child->level < $level): ?> 
		<?php echo str_repeat('</li></ul></div>', $level - $child->level); ?> 
		</li>
		<li>
		<?php $level = $child->level; ?>
		<?php else: ?> 
		</li>
		<li>
		<?php endif; ?>
		<?php echo ($child->anchor)
						? html::anchor($child->anchor, $child->name)
						: $child->name; ?>
	<?php endforeach; ?> 
	<?php echo str_repeat('</li></ul></div>', $level - $node->level); ?> 
</div>
