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
				<?php echo html::anchor('admin/basic/edit/'.$content->id.'?height=800&width=800',
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit')),
					array('class' => 'thickbox')); ?>
				
				<?php echo html::anchor('node/'.$content->node->alias.'?height=700',
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview', 'title'=>'Preview')),
					array('class' => 'thickbox')); ?>
			-
				<?php echo html::anchor('admin/basic/delete/'.$content->id.'?height=200',
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete')),
					array('class' => 'thickbox')); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/basic/create', 'Create New Basic Content'); ?></th>
		</tr>
	</table>	
</div>

