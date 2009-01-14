<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'getimagesize_missing'    => 'Image library benodig die getimagesize() PHP metode, en is nie beskikbaar met jou installasie.',
	'unsupported_method'      => 'Ingestelde driver kan nie die %s beeld transformasie verrig.',
	'file_not_found'          => 'Aangegewe beeld, %s, is nie gevind. Kontroleer eers die bestaan van die beeld deur gebruik van file_exists() voor manipuleer daarvan.',
	'type_not_allowed'        => 'Aangegewe beeld, %s, se beeld tipe is ongeldig.',
	'invalid_width'           => 'Aangegewe wydte, %s, is ongeldig.',
	'invalid_height'          => 'Aangegewe hoogte, %s, is ongeldig.',
	'invalid_dimensions'      => 'Aangegewe groote vir %s is ongeldig.',
	'invalid_master'          => 'Aangegewe bobaas groote is ongeldig.',
	'invalid_flip'            => 'Aangegewe flip rigting is ongeldig.',
	'directory_unwritable'    => 'Aangegewe directory, %s, is onskryfbaar.',

	// ImageMagick specific messages
	'imagemagick' => array
	(
		'not_found' => 'Program %s word benodig. Dit word vermis van die aangegewe ImageMagick directory.',
	),
	
	// GraphicsMagick specific messages
	'graphicsmagick' => array
	(
		'not_found' => 'Program %s word benodig. Dit word vermis van die aangegewe GraphicsMagick directory.',
	),
	
	// GD specific messages
	'gd' => array
	(
		'requires_v2' => 'Image library benodig GD2. Sien http://php.net/gd_info vir meer inligting.',
	),
);
