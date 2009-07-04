<div>
	<h1>Manage Pages</h1>
	<table class="admin">
		<tr>
			<th>Name</th>
			<th>Alias</th>
			<th>Actions</th>
		</tr>
		<?php foreach($pages as $page): ?>
			<tr>
				<td><?php echo $page->name; ?></td>
				<td><?php echo $page->alias; ?></td>
				<td>
				<?php echo html::anchor('admin/pages/edit/'.$page->id,
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit'))); ?>
				<?php echo html::anchor($page->alias,
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview', 'title'=>'Preview'))); ?>
				-
				<?php echo html::anchor('admin/pages/delete/'.$page->id,
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete'))); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/pages/create', 'Create a new Page'); ?></th>
		</tr>
	</table>
</div>