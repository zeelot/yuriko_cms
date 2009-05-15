<?php
/*
 * This should get called by feed_content::render()
 *
 * Variables:
 * <array> $data
 *
 */

?>
<div class="feed">
	<h4>
		<?php echo $data->title; ?>
		<?php echo html::anchor($data->url, html::image(
			'media/images/fam_silk/feed.png')) ?>
	</h4>
	<div>
	<?php foreach($data->items as $item): ?>
		<?php $date = date('M j, g:i:s A', strtotime(isset($item['pubDate'])
				? $item['pubDate']
				: $item['updated'])); ?>
		<h5>
		<?php echo html::specialchars($item['title']) ?>
		- <?php echo $date ?>
		</h5>
		<p>
			<?php echo $item['content']; ?>
		</p>
	<?php endforeach;?>
	</div>
</div>