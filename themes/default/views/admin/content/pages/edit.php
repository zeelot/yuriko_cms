<div>
	<h1>Edit Page: <?php echo $page->name; ?></h1>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="edit_content_page" value="TRUE" />
		<legend>Page Info</legend>
		<label>
			Name: <input type="text" name="name" value="<?php echo $page->name; ?>" />
		</label>
		<label>
			Alias: <input type="text" name="alias" value="<?php echo $page->alias; ?>" />
		</label>
		<button type="submit" name="save" value="save">Save</button>
	</fieldset>
	<?php echo form::close(); ?>
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
				html::image('media/images/fam_silk/bin.png', 'Remove'),
				array('class' => 'thickbox')); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/pages/add_node/'.$page->id,
				'Add a Node'); ?></th>
		</tr>
	</table>
	<h2>Inherited Pages</h2>
	<p class="info">
	All the content from inherited pages is automatically added to the page.
	Things like the main menu can simply be inherited by all pages to simplify
	the creation of new pages.
	</p>
	<ul>
		<?php foreach($page->content_page_inheritances as $inh): ?>
		<li><?php echo $inh->inherited_page->name; ?></li>
		<?php endforeach; ?>
		<li><?php echo html::anchor('admin/pages/add_inheritance/'.$page->id,
				'Inherit Content From Another Page'); ?></li>
	</ul>
</div>