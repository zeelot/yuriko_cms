<div>
	<h1>Edit Page: <?php echo $page->name; ?></h1>
	<?php echo View::factory('admin/content/pages/form')
		->set('page', $page)
		->set('templates', $templates); ?>
	<h2>Content Nodes</h2>
	<table class="admin">
		<tr>
			<th>Section</th>
			<th>Node</th>
			<th>Delete</th>
		</tr>
		<?php foreach($pivots as $pivot): ?>
		<tr>
			<td><?php echo $sections[$pivot->section]; ?></td>
			<td><?php echo $pivot->content_node->name; ?> ( <?php echo $pivot->content_node->alias; ?> )</td>
			<td><?php echo html::anchor('admin/pages/remove_node/'.$pivot->id,
				html::image('media/images/fam_silk/bin.png', 'Remove')); ?></td>
		</tr>
		<?php endforeach; ?>
		<?php Event::run('yuriko.pages_edit_add_nodes_table', $page); ?>
	</table>
	<h2>Inherited Pages</h2>
	<p class="info">
	All the content from inherited pages is automatically added to the page.
	Things like the main menu can simply be inherited by all pages to simplify
	the creation of new pages.
	</p>
	<ul>
		<?php foreach($page->content_page_inheritances as $inh): ?>
		<li>
		<?php echo html::anchor('admin/pages/remove_inheritance/'.$inh->id,
				html::image('media/images/fam_silk/bin.png', 'Remove')); ?>
		<?php echo $inh->inherited_page->name; ?>
		</li>
		<?php endforeach; ?>
		<li><?php echo html::anchor('admin/pages/add_inheritance/'.$page->id,
				'Inherit Content From Another Page'); ?></li>
	</ul>
</div>