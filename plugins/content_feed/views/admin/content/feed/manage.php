<?php

?>

<div>
	<h1>List of Feeds</h1>
	<table class="admin">
		<tr>
			<th>Title</th>
			<th>URL</th>
			<th>Actions</th>
		</tr>
		<?php foreach($contents as $content): ?>
		<tr>
			<td><?php echo $content->title; ?></td>
			<td><?php echo $content->url; ?></td>
			<td>
				<?php echo html::anchor('admin/feed/edit/'.$content->id,
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit'))); ?>
				
				<?php echo html::anchor('node/'.$content->node->alias,
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview', 'title'=>'Preview'))); ?>
			-
				<?php echo html::anchor('admin/feed/delete/'.$content->id,
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete'))); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/feed/create', 'Add another Feed!'); ?></th>
		</tr>
	</table>	
</div>

