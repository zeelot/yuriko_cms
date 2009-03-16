<div>
	<h1>Manage Nodes</h1>
	<h3>Navigation Content</h3>
	<ul>
	<?php foreach($navs as $nav): ?>
		<li>
			<?php echo str_repeat('-----', $nav->level); ?> <?php echo $nav->name; ?>
			<?php $node = Auto_Modeler::factory('content_node', $nav->node_id); ?>
			<?php if($node->id): ?>
			(<?php echo $node->alias; ?>)
			<?php else: ?>
			(<?php echo html::anchor('admin/nodes/attach/navigation/'.$nav->id, 'Attach a new Node'); ?>)
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
	<h3>Basic Content</h3>
	<ul>
	<?php foreach ($basics as $basic): ?>
		<li>
			<?php echo $basic->name; ?>
			<?php $node = Auto_Modeler::factory('content_node', $basic->node_id); ?>
			<?php if($node->id): ?>
			(<?php echo $node->alias; ?>)
			<?php else: ?>
			(<?php echo html::anchor('admin/nodes/attach/basic/'.$basic->id, 'Attach a new Node'); ?>)
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>