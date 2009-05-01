<?php
/*
 * Variables:
 * $nodes = ORM_Iterator of all the basic_content objects
 */

?>

<div>
	<h1>List of Basic Contents</h1>
	<table class="admin">
		<tr>
			<th>Name</th>
			<th>Actions</th>
		</tr>
		<?php foreach($contents as $content): ?>
		<tr>
			<td><?php echo $content->name; ?></td>
			<td>
				<?php echo html::anchor('admin/basic/edit/'.$content->id,
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit'))); ?>
				
				<?php echo html::anchor('node/'.$content->node->alias,
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview', 'title'=>'Preview'))); ?>
			-
				<?php echo html::anchor('admin/basic/delete/'.$content->id,
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete'))); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/basic/create', 'Create New Basic Content'); ?></th>
		</tr>
	</table>	
</div>

