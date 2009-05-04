<?php
/* 
 * This file renders a flat menu without submenus.
 * It will render an MPTT tree but will show all items on the same level.
 */

?>
<div class="navigation">
	<ul>
	<?php foreach($node->subtree()->find_all() as $child): ?>
		<li>
		<?php echo $child->name; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>