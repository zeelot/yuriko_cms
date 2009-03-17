<?php
/*
 * Variables:
 * $nodes = ORM_Iterator of all the navigation_content objects
 */

?>

<div>
	<h1>List of Content Nodes</h1>
	<div class="navigation">
		<?php $level = 0; ?>
		<?php foreach($root->subtree()->find_all() as $child): ?>
			<?php if($child->level > $level): ?>
			<div><ul>
			<li>
			<?php $level++; ?>
			<?php elseif($child->level < $level): ?>
			<?php echo str_repeat('</li></ul></div>', $level - $child->level); ?>
			</li>
			<li>
			<?php $level = $child->level; ?>
			<?php else: ?>
			</li>
			<li>
			<?php endif; ?>
			<?php echo html::anchor('admin/navigation/delete/'.$child->id,
					   html::image('media/images/fam_silk/delete.png', 'Delete Tree')); ?>
			<?php echo $child->name; ?>
		<?php endforeach; ?>
		<?php echo str_repeat('</li></ul></div>', $level); ?>
	</div>
	<?php echo form::open(); ?>
	<fieldset>
		<legend>New Menu Item</legend>
		<input type="hidden" name="new_navigation_form" value="TRUE" />
		<label for="nav.tag">
			Tag: <input type="text" name="tag" id="nav.tag" />
		</label>
		<label for="nav.name">
			Name: <input type="text" name="name" id="nav.name" />
		</label>
		<label for="nav.parent">
			Parent:
			<select name="parent_id" id="nav.parent">
				<?php foreach($nodes as $node): ?>
				<option value="<?php echo $node->id; ?>">
				<?php echo str_repeat('----', $node->level); ?>
				<?php echo $node->name; ?>
				</option>
				<?php endforeach; ?>
			</select>
		</label>
		<button type="submit" name="create" value="create">Create</button>
	</fieldset>
	<?php echo form::close(); ?>
</div>

