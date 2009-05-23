<div>
	<h1>Plugin Management</h1>
	<table class="admin">
		<tr>
			<th>Name</th>
			<th>Version</th>
			<th>Actions</th>
		</tr>
		<?php $cur_status = FALSE; ?>
		<?php foreach($plugins as $plugin): ?>
		<?php if ($plugin->plugin_status_id != $cur_status): ?>
			<?php $cur_status = $plugin->plugin_status_id; ?>
			<tr><th colspan="3"><?php echo $plugin->plugin_status->name; ?></th></tr>
		<?php endif; ?>
		<tr>
			<td><?php echo $plugin->name; ?></td>
			<td><?php echo $plugin->version; ?></td>
			<td>
			<?php echo html::anchor('admin/plugins/info/'.$plugin->id,
				html::image('media/images/fam_silk/information.png',
					array('alt' => 'Info', 'title' => 'Info'))); ?>
			<?php /**PLUGIN IS ENABLED AND HAS INSTALLER*/ ?>
			<?php if($plugin->plugin_status->name == 'enabled' AND $plugin->installer == 1): ?>
			<?php echo html::anchor('admin/plugins/disable/'.$plugin->id,
				html::image('media/images/fam_silk/delete.png',
					array('alt' => 'Remove', 'title' => 'Remove'))); ?>
			<?php echo html::anchor('admin/plugins/install/'.$plugin->id,
				html::image('media/images/fam_silk/database_lightning.png',
					array('alt' => 'Reinstall/Reset', 'title' => 'Reinstall/Reset'))); ?>
			<?php echo html::anchor('admin/plugins/uninstall/'.$plugin->id,
				html::image('media/images/fam_silk/database_delete.png',
					array('alt' => 'Disable and Uninstall', 'title' => 'Disable and Uninstall'))); ?>
			<?php /**PLUGIN IS ENABLED AND HAS NO INSTALLER*/ ?>
			<?php elseif($plugin->plugin_status->name == 'enabled' AND $plugin->installer == 0): ?>
			<?php echo html::anchor('admin/plugins/disable/'.$plugin->id,
				html::image('media/images/fam_silk/delete.png',
					array('alt' => 'Remove', 'title' => 'Remove'))); ?>
			<?php /**PLUGIN IS DISABLED AND HAS INSTALLER*/ ?>
			<?php elseif($plugin->plugin_status->name == 'disabled' AND $plugin->installer == 1): ?>
			<?php echo html::anchor('admin/plugins/enable/'.$plugin->id,
				html::image('media/images/fam_silk/add.png',
					array('alt' => 'Enable', 'title' => 'Add'))); ?>
			<?php echo html::anchor('admin/plugins/install/'.$plugin->id,
				html::image('media/images/fam_silk/database_lightning.png',
					array('alt' => 'Reinstall/Reset', 'title' => 'Reinstall/Reset'))); ?>
			<?php echo html::anchor('admin/plugins/uninstall/'.$plugin->id,
				html::image('media/images/fam_silk/database_delete.png',
					array('alt' => 'Uninstall', 'title' => 'Uninstall'))); ?>
			<?php /**PLUGIN IS DISABLED AND HAS NO INSTALLER*/ ?>
			<?php elseif($plugin->plugin_status->name == 'disabled' AND $plugin->installer == 0): ?>
			<?php echo html::anchor('admin/plugins/enable/'.$plugin->id,
				html::image('media/images/fam_silk/add.png',
					array('alt' => 'Enable', 'title' => 'Add'))); ?>
			<?php /**PLUGIN IS UNINSTALLED AND HAS INSTALLER*/ ?>
			<?php elseif($plugin->plugin_status->name == 'uninstalled' AND $plugin->installer == 1): ?>
			<?php echo html::anchor('admin/plugins/enable/'.$plugin->id,
				html::image('media/images/fam_silk/add.png',
					array('alt' => 'Install and Enable', 'title' => 'Install and Enable'))); ?>
			<?php echo html::anchor('admin/plugins/install/'.$plugin->id,
				html::image('media/images/fam_silk/database_add.png',
					array('alt' => 'Install', 'title' => 'Install'))); ?>
			<?php /**PLUGIN IS UNINSTALLED AND HAS NO INSTALLER*/ ?>
			<?php elseif($plugin->plugin_status->name == 'uninstalled' AND $plugin->installer == 0): ?>
			<?php echo html::anchor('admin/plugins/enable/'.$plugin->id,
				html::image('media/images/fam_silk/add.png',
					array('alt' => 'Install', 'title' => 'Install'))); ?>
			<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>