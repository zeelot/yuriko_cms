
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Basic Content</legend>
		<input type="hidden" name="yuriko_basic_content" value="TRUE" />
		<p class="info">
		The content Name is the unique Identifier. Ex: contact_us.
		</p>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<label>Format:
			<select name="format_id">
				<?php foreach ($formats as $id => $name ): ?>
					<option value="<?php echo $id; ?>" <?php
						echo($item->format->id == $id)? 'selected="selected"' : NULL
					?>><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Content: <textarea name="content" class="markitup"><?php echo $item->content; ?></textarea></label>
	</fieldset>
	<label><button>Save</button></label>
<?php echo form::close(); ?>
</div>