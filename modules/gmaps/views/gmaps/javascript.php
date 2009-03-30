<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
google.load("maps", "2.x", {"language" : "<?php echo substr(Kohana::config('locale.language.0'), 0, 2);?>"});
function initialize() {
	if (GBrowserIsCompatible()) {
		// Initialize the GMap
		<?php echo $map, "\n" ?>
		<?php echo $controls, "\n" ?>
		<?php echo $center, "\n" ?>
		<?php echo $options->render(1), "\n" ?>
		<?php if ( ! empty($icons)): ?>

		// Build custom marker icons
		<?php foreach($icons as $icon): ?>
		<?php echo $icon->render(1), "\n" ?>
		<?php endforeach ?>
		<?php endif ?>

		// Show map points
		<?php foreach($markers as $marker): ?>
		<?php echo $marker->render(1), "\n" ?>
		<?php endforeach ?>
	}
}
google.setOnLoadCallback(initialize);