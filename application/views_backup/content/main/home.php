<div class="message">
    <h1>Welcome!</h1>
    <p>This is my sample page to demostrate my 'Themes' module.</p>
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
	<h2>Example of how views are loaded(Cascading Filesystem):</h2>
	<ul>
		<li><strong>Selected Theme: </strong>themes/views/{theme}/html/template/main.php</li>
		<li><strong>Fallback Theme: </strong>themes/views/default/html/template/main.php</li>
		<li><strong>Fallback Original: </strong>application/views/template/main.php</li>
	</ul>
	<p>No changed to the controller code is needed because the View class
	is automatically extended in the Themes module, everything is transparent!
	Just enable the module, create a new theme and activate it in the config/themes.php file!
	</p>
</div>