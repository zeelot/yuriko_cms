<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
google.load("maps", "2.x", {"language" : "<?php echo substr(Kohana::config('locale.language.0'), 0, 2);?>"});

$(function()
{
	if (GBrowserIsCompatible())
	{
		// Initialize the Gmap
		<?php echo $map, "\n" ?>
		<?php echo $controls, "\n" ?>
		<?php echo $center, "\n" ?>
		<?php echo $options->render(1), "\n" ?> 

		// Load map markers
		$.ajax
		({
			type: 'GET',
			url: '<?php echo url::site('google_map/xml') ?>',
			dataType: 'xml',
			success: function(data, status)
			{
				$(data).find('marker').each(function()
				{
					// Current marker
					var node = $(this);

					// Extract HTML
					var html = node.find('html').text();

					// Create a new map marker
					var marker = new google.maps.Marker(new google.maps.LatLng(node.attr("lat"), node.attr("lon")));
					google.maps.Event.addListener(marker, "click", function()
					{
						marker.openInfoWindowHtml(html);
					});

					// Add the marker to the map
					map.addOverlay(marker);
				});
			},
			error: function(request, status, error)
			{
				alert('There was an error retrieving the marker information, please refresh the page to try again.');
			}
		});
	}
});
// Unload the map when the window is closed
$(document.body).unload(function(){ GBrowserIsCompatible() && GUnload(); });
