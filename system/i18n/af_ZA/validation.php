<?php defined('SYSPATH') OR die('No direct access toegelaat.');

$lang = array
(
	// Class errors
	'invalid_rule'  => 'Gebruik van ongeldige bekragtiging reël: %s',
	'i18n_array'    => 'Die %s i18n sleutel moet \'n array wees om saam met die in_lang reël te kan werk.',
	'not_callable'  => 'Callback %s used for Validation is not callable',

	// General errors
	'unknown_error' => 'Onbekende bekragtings fout geduurende bekragting van %s gedeelte.',
	'required'      => 'die %s gedeelte is \'n vereeiste.',
	'min_length'    => 'Die %s gedeelte moet te minste %d karakters lank wees.',
	'max_length'    => 'Die %s gedeelte moet op die meeste %d karakters bevat.',
	'exact_length'  => 'Die %s gedeelte moet presies %d karakters bevat.',
	'in_array'      => 'Die %s gedeelte moet geselekteer word van die opsies gelys.',
	'matches'       => 'Die %s gedeelte moet die %s gedeelte eweknie.',
	'valid_url'     => 'Die %s gedeelte moet \'n geldige URL bevat.',
	'valid_email'   => 'Die %s gedeelte moet \'n geldige epos adress bevat.',
	'valid_ip'      => 'Die %s gedeelte moet \'n geldige IP adres bevat.',
	'valid_type'    => 'Die %s gedeelte kan slegs %s karakters bevat.',
	'range'         => 'Die %s gedeelte moet binne die gegewe reeks val.',
	'regex'         => 'Die %s gedeelte moet die gegwe entrée eweknie.',
	'depends_on'    => 'Die %s gedeelte hang af van die %s gedeelte.',

	// Upload errors
	'user_aborted'  => 'Die %s lêer het misluk tydens upload.',
	'invalid_type'  => 'Die %s lêer is nie \'n toegelaate lêer tipe.',
	'max_size'      => 'Die %s lêer uploaded was te groot. Die maximum groote toegelaat is %s.',
	'max_width'     => 'Die %s lêer uploaded was te groot. Die maximum wydte toegelaat is %spx.',
	'max_height'    => 'Die %s lêer uploaded was te big. Die maximum hoogte toegelaat is %spx.',
	'min_width'     => 'Die %s lêer uploaded was te small. Die minimum wydte toegelaat is %spx.',
	'min_height'    => 'Die %s lêer uploaded was te small. Die minimum hoogte toegelaat is %spx.',

	// gedeelte types
	'alpha'         => 'alphabeties',
	'alpha_numeric' => 'alphabeties en numeries',
	'alpha_dash'    => 'alphabeties, dash, and tussenstreep',
	'digit'         => 'digit',
	'numeric'       => 'numeries',
);
