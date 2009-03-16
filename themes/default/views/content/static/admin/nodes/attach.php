<div>
	<h1>Attach a new Node to <?php echo $content->name; ?></h1>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="new_node_form" value="TRUE" />
		<input type="hidden" name="content_type" value="<?php echo $type; ?>" />
		<input type="hidden" name="content_id" value="<?php echo $id; ?>" />
		<legend>New Node</legend>
		<label for="node.title">
			Name: <input type="text" id="node.name" name="name" />
		</label>
		<label for="node.alias">
			Alias: <input type="text" id="node.alias" name="alias" />
		</label>
		<button type="submit" name="submit">Create</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>