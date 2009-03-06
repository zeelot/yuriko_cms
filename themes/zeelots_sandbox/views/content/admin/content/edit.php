<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

assets::add_stylesheet('media/editor/markitup/sets/markdown/style', 'markitup');
assets::add_stylesheet('media/editor/markitup/skins/markitup/style', 'markitup');
assets::add_script('media/editor/markitup/jquery.markitup', 'markitup');
assets::add_script('media/editor/markitup/sets/markdown/set', 'markitup');
?>
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