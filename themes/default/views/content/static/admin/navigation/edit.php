
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit Navigation Item "<?php echo $item->name; ?>"</legend>
		<input type="hidden" name="edit_navigation_content" value="TRUE" />
		<label>Tag: <input name="tag" type="text" value="<?php echo $item->tag; ?>" /></label>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<label>Link to a Page:
			<select name="page_id">
				<option value="0" >None</option>
				<?php foreach ($pages as $id => $alias ): ?>
				<option value="<?php echo $id; ?>" <?php echo($item->page_id == $id)? 'selected="selected"' : NULL ?>><?php echo $alias; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			Manual Link:
			<input name="anchor" type="text" value="<?php echo $item->anchor; ?>" /></label>
		</label>
		<label><button>Save</button></label>
	</fieldset>
<?php echo form::close(); ?>
</div>
