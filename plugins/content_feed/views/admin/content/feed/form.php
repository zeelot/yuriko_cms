
<div>
<?php echo form::open(); ?>
	<fieldset>
		<legend>Feed</legend>
		<input type="hidden" name="yuriko_feed_content" value="TRUE" />
		<p class="info">
		The feed Name is the unique Identifier. Ex: forum_rss.
		</p>
		<label>Name: <input name="name" type="text" value="<?php echo $item->name; ?>" /></label>
		<p class="info">
		The feed Title is what the visitors see.
		</p>
		<label>Title: <input name="title" type="text" value="<?php echo $item->title; ?>" /></label>
		<label>URL: <input name="url" type="text" value="<?php echo $item->url; ?>" /></label>
	</fieldset>
	<?php echo (isset($node_arguments))? $node_arguments:NULL; ?>
	<label><button>Save</button></label>
<?php echo form::close(); ?>
</div>