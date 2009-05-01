
<div>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="page_add_content_node" value="TRUE" />
		<legend>Add Content Node</legend>
		<label for="page.node">
		Node: <?php echo $node_dropdown; ?>
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