
<div>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="new_page_content" value="TRUE" />
		<legend>New Page</legend>
		<label for="page.name">
			Name: <input type="text" id="page.name" name="name" value="<?php echo $page->name; ?>"/>
		</label>
		<label for="page.alias">
			Alias: <input type="text" id="page.alias" name="alias" />
		</label>
		<button type="submit" name="submit">Create</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>