<div>
	<h1>Plugin Management</h1>
	<table class="admin">
		<tr>
			<th>Name</th>
			<th>Version</th>
			<th>Actions</th>
		</tr>
		<?php foreach($plugins as $plugin): ?>
		<tr>
			<td><?php echo $plugin->name; ?></td>
			<td><?php echo $plugin->version; ?></td>
			<td>
			<?php echo html::anchor('admin/plugins/info/'.$plugin->id.'?height=500',
				html::image('media/images/fam_silk/information.png',
					array('alt' => 'Info', 'title' => 'Info')),
				array('class' => 'thickbox')); ?>
			<?php if(!$plugin->enabled): ?>
			<?php echo html::anchor('admin/plugins/enable/'.$plugin->id.'?height=200',
				html::image('media/images/fam_silk/add.png',
					array('alt' => 'Enable', 'title' => 'Add')),
				array('class' => 'thickbox')); ?>
			<?php else: ?>
			<?php echo html::anchor('admin/plugins/disable/'.$plugin->id.'?height=200',
				html::image('media/images/fam_silk/delete.png',
					array('alt' => 'Remove', 'title' => 'Remove')),
				array('class' => 'thickbox')); ?>
			<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>