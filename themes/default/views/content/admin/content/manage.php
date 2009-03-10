<?php
/*
 * Variables:
 * $nodes = ORM_Iterator of all the basic_content objects
 */

?>

<div>
	<h1>List of Content Nodes</h1>
	<ul>
		<?php foreach($nodes as $node): ?> 
		<li><?php echo html::anchor('admin/content/edit/'.$node->id, $node->name); ?></li>
		<?php endforeach; ?>
	</ul>
</div>

