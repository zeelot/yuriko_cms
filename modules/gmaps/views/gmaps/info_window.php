<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="gmap-html">
<span class="image"><?php echo html::image(array('src' => $location->link, 'alt' => $location->title, 'width' => 100, 'height' => 100)) ?></span>
<h6 class="title"><?php echo $location->title ?></h6>
<?php

echo '<p>', implode("</p>\n<p>", explode("\n\n", $location->description)), "</p>\n";

?>
<p class="link"><?php echo html::anchor($location->link, $location->title) ?></p>
</div>