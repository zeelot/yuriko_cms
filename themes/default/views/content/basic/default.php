<?php
/* 
 * This should get called by basic_content::render()
 *
 * Variables:
 * <AM Object> $node
 * $node->alias      the url segment to access this content directly
 * $node->content    the formatted content (usually markdown)
 * $node->html       the html of content
 *
 */

?>
<div>
	<?php echo $node->html; ?>
</div>