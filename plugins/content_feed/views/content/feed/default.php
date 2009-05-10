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
	<dl>
	<?php foreach($data->items as $item): ?>
		<?php $date = date('M j, g:i:s A', strtotime(isset($item['pubDate'])
				? $item['pubDate']
				: $item['updated'])); ?>
		<di><?php echo html::specialchars($item['title']) ?></di>
		<dd>
			<?php echo $date ?>
			-
			<?php echo html::anchor(isset($item['link'])
				? $item['link']
				: $item['id'], 'Read More')?>
		</dd>
	<?php endforeach;?>
	</dl>
</div>