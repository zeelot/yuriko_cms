<?php
/*
 * Variables:
 * $nodes = ORM_Iterator of all the basic_content objects
 */

?>

<div>
	<h1>List of Content Nodes</h1>
	<table>
		<tr>
			<th>Name</th>
			<th>Edit</th>
			<th>Node</th>
			<th>Delete</th>
		</tr>
		<?php foreach($pages as $page): ?>
		<tr>
			<td><?php echo $page->name; ?></td>
			<td>
				<?php echo html::anchor('admin/basic/edit/'.$page->id,
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit'))); ?>
			</td>
			<td>
				<?php if(!$page->has_node()): ?>
				<?php echo html::anchor('admin/basic/create_node/'.$page->id,
					html::image('media/images/fam_silk/plugin_add.png',
						array('alt'=>'Attach to Node', 'title'=>'Create Node'))); ?>
				<?php else: ?>
				<?php echo html::anchor('admin/basic/delete_node/'.$page->id,
					html::image('media/images/fam_silk/plugin_delete.png',
						array('alt'=>'Detach from Node', 'title'=>'Delete Node'))); ?>
				<?php endif; ?>
			</td>
			<td>
				<?php echo html::anchor('admin/basic/delete/'.$page->id,
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete'))); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="4"><?php echo html::anchor('admin/basic/create', 'Create New Basic Content'); ?></th>
		</tr>
	</table>	
</div>

