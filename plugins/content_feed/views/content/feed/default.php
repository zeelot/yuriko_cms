<?php
/* 
 * This should get called by feed_content::render()
 *
 * Variables:
 * <array> $data
 *
 */

?>
<div>
	<h6 class="feed"><?php echo html::anchor($data->url, $data->title) ?></h6>
	<ul>
	<?php
		foreach($data->items as $item):
			$date = date('M j, g:i:s A', strtotime(isset($item['pubDate']) ? $item['pubDate'] : $item['updated']));
	?>
		<li><strong><?php echo html::specialchars($item['title']) ?></strong> &ndash; <?php echo $date ?> - <?php echo html::anchor(isset($item['link']) ? $item['link'] : $item['id'], 'Read More')?></li>
	<?php endforeach;?>
	</ul>
</div>