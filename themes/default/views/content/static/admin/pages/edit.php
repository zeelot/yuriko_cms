<div>
	<h1>Edit Page: <?php echo $page->name; ?></h1>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="edit_content_page" value="TRUE" />
		<legend>Page Info</legend>
		<label for="page.name">
			Name: <input type="text" id="page.name" name="name" value="<?php echo $page->name; ?>" />
		</label>
		<label for="page.alias">
			Alias: <input type="text" id="page.alias" name="alias" value="<?php echo $page->alias; ?>" />
		</label>
		<button type="submit" name="save" value="save">Save</button>
	</fieldset>
	<?php echo form::close(); ?>
	<h2>Content Nodes</h2>
	<table>
		<tr>
			<th>Node</th>
			<th>Section</th>
			<th>Delete</th>
		</tr>
		<?php foreach($objects as $obj): ?>
		<tr>
			<td><?php echo $obj->content_section->name; ?></td>
			<td><?php echo $obj->content_node->name; ?></td>
			<td><?php echo html::anchor('admin/pages/remove_node/'.$obj->id,
				   html::image('media/images/fam_silk/delete.png', 'Remove')); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/pages/add_node/'.$page->id, 'Add a Node'); ?></th>
		</tr>
	</table>
</div>