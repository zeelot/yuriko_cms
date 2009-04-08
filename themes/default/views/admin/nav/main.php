
<!-- START MENUS -->
<div class="menu">
	<h3>Content</h3>
	<ul>
		<li><?php echo html::anchor('admin/pages/manage', 'Pages'); ?></li>
		<?php Event::run('admin.nav.content'); ?>
	</ul>
	<h3>Site</h3>
	<ul>
		<li><?php echo html::anchor('admin/settings/manage', 'Settings'); ?></li>
		<li><?php echo html::anchor('admin/plugins/manage', 'Plugins'); ?></li>
		<li><?php echo html::anchor('admin/users/manage', 'Users'); ?></li>
	</ul>
</div>
<!-- END MENUS -->
