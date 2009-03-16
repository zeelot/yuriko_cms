<?php
/*
 * Variables:
 * $nodes = ORM_Iterator of all the basic_content objects
 */

?>

<div>
	<h1>List of Content Nodes</h1>
	<ul>
		<?php foreach($nodes as $node): ?> 
		<li><?php echo html::anchor('admin/basic/edit/'.$node->id, $node->name); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="new_basic_form" value="TRUE" />
		<input type="hidden" name="content" value="Content" />
		<input type="hidden" name="format_id" value="1" />
		<legend>Create Basic Content</legend>
		<label for="basic.name">
			Name: <input type="text" id="basic.name" name="name" />
		</label>
		<button type="submit" name="submit">Create</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>

