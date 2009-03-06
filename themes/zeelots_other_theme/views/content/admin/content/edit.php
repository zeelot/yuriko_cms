
<div>
<h1>Edit Content</h1>
<?php echo form::open(); ?>
	<label>Name: <input type="text" value="<?php echo $item->name; ?>" /></label>
	<label>Content: <textarea id="markdown"><?php echo $item->content; ?></textarea></label>
	<label><button>Save</button></label>
<?php echo form::close(); ?>
</div>
<div class="preview">
	<h2>Preview</h2>
	<?php echo $item->html; ?>
</div>