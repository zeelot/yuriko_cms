
<!-- START MENUS -->
<div class="menu">
	<?php Event::run('yuriko.pre_admin_nav_content'); ?>
	<h3>Content</h3>
	<ul>
		<li><?php echo html::anchor('admin/pages/manage', 'Pages'); ?></li>
		<?php Event::run('yuriko.admin_nav_content'); ?>
	</ul>
	<?php Event::run('yuriko.post_admin_nav_content'); ?>
	<h3>Site</h3>
	<ul>
		<li><?php echo html::anchor('admin/settings/manage', 'Settings'); ?></li>
		<li><?php echo html::anchor('admin/plugins/manage', 'Plugins'); ?></li>
		<?php Event::run('yuriko.admin_nav_site'); ?>
	</ul>
	<?php Event::run('yuriko.post_admin_nav_site'); ?>
	<h3>Plugins</h3>
	<ul>
		<?php Event::run('yuriko.admin_nav_plugins'); ?>
	</ul>
	<?php Event::run('yuriko.post_admin_nav_plugins'); ?>
</div>
<!-- END MENUS -->
