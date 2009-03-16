<div>
	<h1>Manage Pages</h1>
	<ul>
	
	<?php foreach($nodes as $node): ?>
		<li>
			<?php echo $node->title; ?>
			(<?php echo html::anchor('admin/pages/edit/'.$node->id, 'Edit'); ?>)
			(<?php echo html::anchor($node->alias, 'Visit'); ?>)
		</li>
	<?php endforeach; ?>
	</ul>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="new_page_form" value="TRUE" />
		<legend>New Page</legend>
		<label for="page.title">
			Title: <input type="text" id="page.title" name="title" />
		</label>
		<label for="page.alias">
			Alias: <input type="text" id="page.alias" name="alias" />
		</label>
		<button type="submit" name="submit">Create</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>