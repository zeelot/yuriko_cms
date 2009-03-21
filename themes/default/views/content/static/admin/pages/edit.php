<div>
	<h1>Edit Page: <?php echo $page->title; ?></h1>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="page_info_form" value="TRUE" />
		<legend>Page Info</legend>
		<label for="page.title">
			Title: <input type="text" id="page.title" name="title" value="<?php echo $page->title; ?>" />
		</label>
		<label for="page.alias">
			Alias: <input type="text" id="page.alias" name="alias" value="<?php echo $page->alias; ?>" />
		</label>
		<button type="submit" name="save" value="save">Save</button>
	</fieldset>
	
	<fieldset>
		<legend>Contents</legend>
		<ul>
			<?php foreach($objects as $obj): ?>
			<li>
			<?php echo html::anchor('admin/pages/remove_node/'.$obj->id,
					   html::image('media/images/fam_silk/delete.png', 'Remove')); ?>
			<?php echo $obj->content_section->name; ?> : <?php echo $obj->content_node->name; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</fieldset>
	<?php echo form::close(); ?>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="page_add_node_form" value="TRUE" />
		<legend>Add Content</legend>
		<label for="page.node">
		Node:
		<select name="node" id="page.node">
			<?php foreach($nodes as $id => $name): ?>
			<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		</label>
		<label for="page.section">
		Section:
		<select name="section" id="page.section">
			<?php foreach($sections as $id => $name): ?>
			<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		</label>
		<button type="submit" name="add" value="add">Add</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>