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
				<?php echo html::anchor($page->alias.'?height=700&width=1100',
					html::image('media/images/fam_silk/zoom.png',
						array('alt'=>'Preview', 'title'=>'Preview')),
					array('class' => 'thickbox')); ?>
				-
				<?php echo html::anchor('admin/pages/delete/'.$page->id.'?height=200',
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete')),
					array('class' => 'thickbox')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/pages/create?height=250&width=300', 'Create a new Page',
					array('class' => 'thickbox')); ?></th>
		</tr>
	</table>
</div>