
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>New Basic Content</legend>
		<input type="hidden" name="create_basic_content" value="TRUE" />
		<p class="info">
		The page Name is the unique Identifier.  It can contain most character
		and letters but must not contain spaces. Ex: contact_us.
		</p>
		<label>Name: <input name="name" type="text" value="<?php echo (isset($_POST['name']))?$_POST['name']:NULL;?>" /></label>
		<p class="info">
		The GUI for the content only works with Markdown at the moment.
		However, you can select HTML as the format and type up your content
		in HTML manually.
		</p>
		<label>Format:
			<select name="format_id">
				<?php foreach ($formats as $id => $name ): ?>
				<option value="<?php echo $id; ?>" ><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Content: <textarea name="content" class="markitup"><?php echo (isset($_POST['content']))?$_POST['content']:NULL;?></textarea></label>
	</fieldset>
	<fieldset>
		<legend>Advanced Settings</legend>
		<p class="info">
		The View is the file responsible for rendering content.  If you don't know how these
		settings work, leave them with the default value!
		</p>
		<label>View:
			<select name="view">
				<?php foreach(Kohana::list_files('views/content/basic') as $file): ?>
				<option value="<?php echo basename($file, '.php'); ?>" <?php echo (basename($file, '.php') == $item->view)? 'selected="selected"':NULL; ?>><?php echo basename($file, '.php'); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</fieldset>
	<label><button>Create</button></label>
<?php echo form::close(); ?>
</div>