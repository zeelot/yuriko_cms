<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'there_can_be_only_one' => 'Slegs een instansie van Kohana per bladsy versoek mag bestaan.',
	'uncaught_exception'    => 'Onbetrapte %s: %s in lêer %s op reël %s',
	'invalid_method'        => 'Ongeldige metode %s opgeroep in %s',
	'invalid_property'      => 'Die %s eienskap bestaan nie in klas %s.',
	'log_dir_unwritable'    => 'Die log directory is nie skryfbaar nie: %s',
	'resource_not_found'    => 'Die versoekte %s, %s, is nie gevind nie.',
	'invalid_filetype'      => 'Die versoekte filetype, .%s, is nie toegelaat in jou view konfigurasie lêer.',
	'view_set_filename'     => 'Jy moet die naam van die view lêer stel voordat render opgeroep word.',
	'no_default_route'      => 'Stel asseblief \'n standard roete in config/routes.php',
	'no_controller'         => 'Kohana kan nie bepaal watter kontroller die versoek: %s moet hanteer.',
	'page_not_found'        => 'Die versoekte bladsy, %s, is nie gevind nie.',
	'stats_footer'          => 'Gelaai in {execution_time} sekondes,  {memory_usage} van geheue. Opgelewer met Kohana v{kohana_version}.',
	'error_file_line'       => '<tt>%s <strong>[%s]:</strong></tt>',
	'stack_trace'           => 'Stack Trace',
	'generic_error'         => 'Versoek onvoltooibaar.',
	'errors_disabled'       => 'Gaan na die <a href="%s">tuis bladsy</a> of <a href="%s">probeer weer</a>.',

	// Drivers
	'driver_implements'     => 'Die %s driver vir die %s library implemeteer nie die %s interface nie.',
	'driver_not_found'      => 'Die %s driver vir die %s library is nie gevind nie.',

	// Resource names
	'config'                => 'konfigurasie lêer',
	'controller'            => 'kontroller',
	'helper'                => 'helper',
	'library'               => 'library',
	'driver'                => 'driver',
	'model'                 => 'model',
	'view'                  => 'view',
);
