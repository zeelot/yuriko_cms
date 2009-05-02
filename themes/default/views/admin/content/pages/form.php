
<div>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="yuriko_page" value="TRUE" />
		<legend>Page</legend>
		<label for="page_name">
			Name: <input type="text" id="page_name" name="name" value="<?php echo $page->name; ?>"/>
		</label>
		<label for="page_alias">
			Alias: <input type="text" id="page_alias" name="alias" value="<?php echo $page->alias; ?>" />
		</label>
		<label for="page_template">
		Template:
		<select name="template" id="page_template">
			<?php foreach($templates as $template): ?>
			<option value="<?php echo basename($template); ?>"><?php echo basename($template); ?></option>
			<?php endforeach; ?>
		</select>
		<button type="submit" name="submit">Save</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>