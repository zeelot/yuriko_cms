<!-- START NOTICE MESSAGES -->
<div class="notices <?php echo $type; ?>">
	<ul>
		<?php foreach($notices as $notice): ?>
		<li><?php echo $notice; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<!-- END NOTICE MESSAGES -->