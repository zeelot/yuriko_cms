
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit Basic Page Content</legend>
		<input type="hidden" name="edit_content" value="TRUE" />
		<input type="hidden" name="id" value="<?php echo $item->id; ?>" />
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<label>Format:
			<select name="format_id">
				<?php foreach ($formats as $id => $name ): ?>
				<option value="<?php echo $id; ?>" <?php echo($item->format->id == $id)? 'selected="selected"' : NULL ?>><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Content: <textarea name="content" id="markdown"><?php echo $item->content; ?></textarea></label>
		<label><button>Save</button></label>
	</fieldset>
<?php echo form::close(); ?>
</div>
<div class="preview">
	<h2>Preview</h2>
	<?php echo $item->html; ?>
</div>