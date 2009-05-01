
<select name="node" id="navigation_node">
	<?php foreach($items as $item): ?>
	<option value="<?php echo $item->node_id; ?>">
	<?php echo $item->name; ?>
	</option>
	<?php endforeach; ?>
</select>