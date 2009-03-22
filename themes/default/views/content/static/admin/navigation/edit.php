
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit Navigation Item "<?php echo $item->name; ?>"</legend>
		<p class="info">
		The <strong>Tag</strong> field is a unique identifier for the Navigation Item.
		Usually	it is good practice to use the path to the item as the tag (this
		ensures the tag will be unique). Ex: main.home (as a tag for the Home link
		located under the Main Menu).  The <strong>Name</strong> field is the
		text the visitors will see in the menu.
		</p>
		<input type="hidden" name="edit_navigation_content" value="TRUE" />
		<label>Tag: <input name="tag" type="text" value="<?php echo $item->tag; ?>" /></label>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		
		<p class="info">
		Navigation Items can be links to Pages (which will tie a link to a page
		alias), or you can set a manual link to specify an outside page like
		'http://google.com'.  If a Page is selected, the Manual Link field will
		be ignored.
		</p>
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
