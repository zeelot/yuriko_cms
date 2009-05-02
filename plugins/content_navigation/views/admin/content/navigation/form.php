
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Edit Navigation Item "<?php echo $item->name; ?>"</legend>
		<p class="info">
		The <strong>Tag</strong> field is a unique identifier for the Navigation Item.
		Ex: main.home (as a tag for the Home link located under the Main Menu).
		</p>
		<input type="hidden" name="yuriko_navigation_content" value="TRUE" />
		<label>Tag: <input name="tag" type="text" value="<?php echo $item->tag; ?>" /></label>
		<p>
		The <strong>Name</strong> field is the text the visitors will see in the menu.
		</p>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<p class="info">
		The <strong>Parent</strong> is the location you want this item to be placed in.
		root will start a new Navigation Tree.
		</p>
		<label for="nav_parent">
			Parent:
			<select name="parent_id" id="nav_parent">
				<?php foreach($items as $i): ?>
				<option value="<?php echo $i->id; ?>" <?php 
					echo ($i->id == $item->parent->id)? 'selected="selected"':NULL;
				?>>
				<?php echo str_repeat('----', $i->level); ?>
				<?php echo $i->name; ?>
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
				<option value="<?php echo $id; ?>" <?php echo($item->page_id == $id)? 'selected="selected"' : NULL ?>><?php echo $alias; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			Manual Link:
			<input name="anchor" type="text" value="<?php echo $item->anchor; ?>" /></label>
		</label>
	</fieldset>
	<label><button>Save</button></label>
<?php echo form::close(); ?>
</div>
