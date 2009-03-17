<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="kohana-profiler">
<?php
foreach ($profiles as $profile)
{
	echo $profile->render();
}
?>
<p class="kp-meta">Profiler executed in <?php echo number_format($execution_time, 3) ?>s</p>
</div>