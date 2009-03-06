<div class="message">
    <h1>Theme Module Documentation</h1>
	<p>
	The themes can overwrite any default view.
	Each theme can have it's own css, js, and image directories for
	theme specific files. Global media files like JS or CSS Libraries
	can go in the global media directory.
	</p>
	<p>The module will never break your current application.
	Enabling the module will let you overwrite your old views but will fall
	back to the originals for any view that is missing in the themes.
	</p>
	<p>No changed to the controller code is needed because the View class
	is automatically extended in the Themes module, everything is transparent!
	Just enable the module, create a new theme and activate it in the config/themes.php file!
	</p>
	<pre>
		View::factory('hello/world');
		/**
		 * This will try to load the following views in order until one is found:
		 * themes/{current_theme}/hello/world.php
		 * themes/default/hello/world.php
		 * hello/world.php (default kohana behaviour)
		 */
	</pre>
	<h2>TODO:</h2>
	<ul>
		<li>Clean and Document Module Code</li>
		<li>A better way to handle assets(theme/global assets)</li>
		<li>Install/Uninstall Themes From the DB</li>
	</ul>
</div>