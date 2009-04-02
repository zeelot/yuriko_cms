<div>
	<h1>Site Settings</h1>
	<?php echo form::open(); ?>
	<fieldset>
		<input type="hidden" name="site_settings" value="TRUE" />
		<legend>Site Information</legend>
		<label>Site Name: <input type="text" name="site_name" id="site_name" value="<?php echo (isset($settings['site_name']))? $settings['site_name']:NULL; ?>"/></label>
		<label>Site Description: <input type="text" name="site_description" id="site_description" value="<?php echo (isset($settings['site_description']))? $settings['site_description']:NULL; ?>"/></label>
	</fieldset>
	<?php foreach(form_module::get('site_settings') as $module): ?>
		<?php echo $module; ?>
	<?php endforeach; ?>
	<button type="submit" name="save" value="save">Save</button>
	<?php echo form::close(); ?>
</div>