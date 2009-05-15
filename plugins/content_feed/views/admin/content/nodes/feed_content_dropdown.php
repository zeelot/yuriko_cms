
<select name="content_node_id" id="page_node">
	<?php foreach($items as $item): ?>
	<option value="<?php echo $item->node_id; ?>">
	<?php echo $item->name; ?>
	</option>
	<?php endforeach; ?>
</select>
