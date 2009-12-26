<?php
/**
 * $group - group of notices
 * $notices - array of notices
 */
?>
<!-- START NOTICE MESSAGES -->
<div class="notices">
	<h4>Notices: <?php echo ucfirst($group) ?></h4>
	<ul>
		<?php foreach($notices as $notice): ?>
		<li class="<?php echo $notice['attr']['class']; ?>">
			<?php echo $notice['message']; ?> 
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<!-- END NOTICE MESSAGES -->