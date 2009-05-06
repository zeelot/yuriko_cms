<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'enabled' => array
	(
		'core_upgrade'         => 'Plugin seems to be made for newer versions of the CMS (%s).
                                   Try upgrading CMS or looking for an older version of this plugin.',
		'core_downgrade'       => 'Plugin seems to only work with an older version of the CMS (%s).
                                   Try looking for a newer version of this plugin.',
		'dependency_install'   => 'Plugin requires "%s" version %s or higher. Which does not seem to be installed.',
		'dependency_enable'    => 'Plugin requires "%s" version %s or higher. You will need to enable this plugin first.',
		'dependency_upgrade'   => 'Plugin requires "%s" version %s or higher. You will need to upgrade this plugin first.',
		'dependency_downgrade' => 'Plugin requires %s version %s or lower.
                                   You can look for an updated version of this plugin or downgrade the required plugins.',
		'needed' => 'Plugin is needed by %s. You will need to disable that plugin first.',
		'default'  => 'Error Enabling Plugin.',
	),
	'dependencies' => array
	(
		'default'  => 'Error Syncing Plugins.',
	),
);
