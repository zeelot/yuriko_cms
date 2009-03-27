<?php
/*
 * Variables:
 * $root = ORM_MPTT of the root node
 */

?>

<div>
	<h1>List of Navigation Items</h1>
	<table>
		<tr>
			<th>Name</th>
			<th>Sort</th>
			<th>Actions</th>
		</tr>
		<?php foreach($root->subtree()->find_all() as $child): ?>
		<?php
		$sort_up = ($child->lft - $child->parent->lft > 1)? TRUE : FALSE;
		$sort_down = ($child->parent->rgt - $child->rgt > 1)? TRUE : FALSE;
		?> 
			<tr>
				<td>
				<?php echo str_repeat('----', $child->level - 1); ?>
				<?php if(($child->page_id > 0) OR ($child->anchor)): ?>
				<?php echo ($child->page_id > 0)
					? html::anchor(Auto_Modeler::factory('content_page', $child->page_id)->alias, $child->name)
					: html::anchor($child->anchor, $child->name) ?>
				<?php else: ?>
				<?php echo $child->name; ?>
				<?php endif; ?>
				</td>
				<td>
				<?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $child->level - 1); ?>
				<?php if($sort_up):?>
				<?php echo html::anchor('admin/navigation/move_up/'.$child->id,
					html::image('media/images/fam_silk/arrow_up.png',
						array('alt'=>'Move Up', 'title'=>'Move Up'))); ?>
				<?php endif; ?>
				<?php if($sort_down):?>
				<?php echo html::anchor('admin/navigation/move_down/'.$child->id,
					html::image('media/images/fam_silk/arrow_down.png',
						array('alt'=>'Move Down', 'title'=>'Move Down'))); ?>
				<?php endif; ?>
				</td>
				<td>
				<?php echo html::anchor('admin/navigation/edit/'.$child->id.'?height=600',
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit')),
					array('class' => 'thickbox')); ?>
				<?php echo html::anchor('node/'.$child->node->alias.'?width=800&height=500',
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview Node', 'title'=>'Preview Node')),
				array('class' => 'thickbox')); ?>
				-
				<?php echo html::anchor('admin/navigation/delete/'.$child->id.'?height=200',
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete')),
					array('class' => 'thickbox')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/navigation/create?height=650',
				'Create New Navigation Item',
				array('class' => 'thickbox')); ?></th>
		</tr>
	</table>
</div>

