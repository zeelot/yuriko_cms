
<div>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="page_add_inheritance" value="TRUE" />
		<legend>Inherit Content</legend>
		<label>
		Page:
		<select name="page_id">
			<?php foreach($pages as $page): ?>
			<option value="<?php echo $page->id; ?>"><?php echo $page->name; ?></option>
			<?php endforeach; ?>
		</select>
		</label>
		<button type="submit" name="add" value="add">Add</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>