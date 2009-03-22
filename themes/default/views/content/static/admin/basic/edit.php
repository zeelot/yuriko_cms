
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit Basic Content</legend>
		<input type="hidden" name="edit_basic_content" value="TRUE" />
		<p class="info">
		The page Name is the unique Identifier.  It can contain most character
		and letters but must not contain spaces. Ex: contact_us.
		</p>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<p class="info">
		The GUI for the content only works with Markdown at the moment.
		However, you can select HTML as the format and type up your content
		in HTML manually.
		</p>
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