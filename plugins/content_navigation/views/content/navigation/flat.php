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
		<?php if(($child->anchor) OR ($child->page_id > 0)): ?>
		<?php echo ($child->page_id > 0)
					? html::anchor(ORM::factory('content_page', $child->page_id)->alias, $child->name)
					: html::anchor($child->anchor, $child->name) ?>
		<?php else: ?>
		<?php echo $child->name; ?>
		<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>