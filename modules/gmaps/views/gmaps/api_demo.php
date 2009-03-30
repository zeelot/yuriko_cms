<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Google Maps JavaScript API Example</title>
<script src="<?php echo $api_url ?>" type="text/javascript"></script>
<script type="text/javascript">
<?php echo $map ?>
</script>
</head>
<body>
<p>You can use your scroll wheel to zoom in and out of the map.</p>
<div id="map" style="width: 600px; height: 400px"></div>
</body>
</html>