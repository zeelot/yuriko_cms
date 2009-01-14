<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'file_not_found' => 'Die bepaalde lêer, %s, kon nie gevind word nie. Kontroleer asseblief dat lêers bestaan deur middel van file_exists() voor gebruik daarvan.',
	'requires_GD2'   => 'Die Captcha library benodig GD2 met FreeType ingesluit. Sien http://php.net/gd_info vir meer inligting.',

	// Words of varying length for the Captcha_Word_Driver to pick from
	// Note: use only alphanumeric characters
	'words' => array
	(
		'cd', 'tv', 'it', 'to', 'be', 'or',
		'son', 'kar', 'kat', 'bed', 'dag', 'dak',
		'meer', 'boom', 'boot', 'huis', 'slot', 'hare',
		'snaar', 'moord', 'naald', 'parys', 'berou', 'water',
		'barber', 'bakery', 'banana', 'market', 'purple', 'writer',
		'america', 'release', 'playing', 'working', 'foreign', 'general',
		'aircraft', 'computer', 'laughter', 'alphabet', 'kangaroo', 'spelling',
		'architect', 'president', 'cockroach', 'encounter', 'terrorism', 'cylinders',
	),

	// Riddles for the Captcha_Riddle_Driver to pick from
	// Note: use only alphanumeric characters
	'riddles' => array
	(
		array('Maak spam jou mal? (ja of nee)', 'ja'),
		array('Is jy \'n robot? (ja of nee)', 'nee'),
		array('Vuur is... (warm of koud)', 'warm'),
		array('Die seisoen na herfs is...', 'winter'),
		array('Watter dag van die week is dit vandag?', strftime('%A')),
		array('In watter maand bevind ons tans?', strftime('%B')),
	),
);
