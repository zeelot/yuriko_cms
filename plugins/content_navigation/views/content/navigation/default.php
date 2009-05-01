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
		<?php if(($child->anchor) OR ($child->page_id > 0)): ?>
		<?php echo ($child->page_id > 0)
					? html::anchor(ORM::factory('content_page', $child->page_id)->alias, $child->name)
					: html::anchor($child->anchor, $child->name) ?>
		<?php else: ?>
		<?php echo $child->name; ?>
		<?php endif; ?>
	<?php endforeach; ?> 
	<?php echo str_repeat('</li></ul></div>', $level - $node->level); ?> 
</div>
