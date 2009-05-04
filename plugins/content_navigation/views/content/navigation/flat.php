<?php
/* 
 * This file renders a flat menu without submenus.
 * For MPTT Trees this file will not go beyond the first level
 */

?>
<div class="navigation">
	<ul>
	<?php foreach($node->children as $child): ?>
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