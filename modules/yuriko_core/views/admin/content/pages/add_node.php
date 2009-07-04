
<div>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="yuriko_page_add_node" value="TRUE" />
		<input type="hidden" name="content_page_id" value="<?php echo $page->id; ?>" />
		<legend>Add Content Node</legend>
		<label for="page_node">
		Node: <?php echo $node_dropdown; ?>
		</label>
		<label for="page_section">
		Section:
		<select name="section" id="page_section">
			<?php foreach($sections as $id => $name): ?>
			<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		<label for="node_view">
		View:
		<select name="view" id="node_view">
			<?php foreach($views as $view): ?>
			<option value="<?php echo basename(rtrim($view, '.php')); ?>"><?php echo basename($view); ?></option>
			<?php endforeach; ?>
		</select>
		</label>
		</label>
	</fieldset>
	<?php echo (isset($node_arguments))? $node_arguments:NULL; ?>
	<button type="submit" name="add" value="add">Add</button>
	<?php echo form::close(); ?>
</div>