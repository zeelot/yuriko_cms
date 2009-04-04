<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>New Navigation Item</legend>
		<p class="info">
		The <strong>Tag</strong> field is a unique identifier for the Navigation Item.
		Usually	it is good practice to use the path to the item as the tag (this
		ensures the tag will be unique). Ex: main.home (as a tag for the Home link
		located under the Main Menu).  The <strong>Name</strong> field is the
		text the visitors will see in the menu.
		</p>
		<p class="info">
		The <strong>Parent</strong> is the location you want this item to be placed in.
		root will start a new Navigation Tree (like Admin Menu).
		All the links under Admin Menu will have a Parent of 'Admin Menu'.
		You can have as many sub-menu's as you like.
		</p>
		<input type="hidden" name="new_navigation_content" value="TRUE" />
		<label>Tag: <input name="tag" type="text" value="<?php echo (isset($_POST['tag']))?$_POST['tag']:NULL;?>" /></label>
		<label>Name: <input name="name" type="text" value="<?php echo (isset($_POST['name']))?$_POST['name']:NULL;?>" /></label>
		<label for="nav.parent">
			Parent:
			<select name="parent_id" id="nav.parent">
				<?php foreach($items as $item): ?>
				<option value="<?php echo $item->id; ?>">
				<?php echo str_repeat('----', $item->level); ?>
				<?php echo $item->name; ?>
				</option>
				<?php endforeach; ?>
			</select>
		</label>
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
				<option value="<?php echo $id; ?>" ><?php echo $alias; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			Manual Link:
			<input name="anchor" type="text" value="<?php echo (isset($_POST['anchor']))?$_POST['anchor']:NULL;?>" /></label>
		</label>
		<button type="submit" name="create">Craete</button>
	</fieldset>
<?php echo form::close(); ?>
</div>
