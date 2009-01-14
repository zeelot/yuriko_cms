<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * You should set your own API key in application/config/gmaps.php
 * This API key is usable for http://localhost/*
 */

$config['api_key'] = 'ABQIAAAAnfs7bKE82qgb3Zc2YyS-oBT2yXp_ZAY8_ufC3CFXhHIE1NvwkxSySz_REpPq-4WZA27OwgbtyR3VcA';

/**
 * Using a localised google domain gives more accurated results on geolocation
 * For example, searches for "Toledo" will return different results within the domain of Spain (http://maps.google.es) 
 * specified by a country code of "es" than within the default domain within the United States (http://maps.google.com).
 */

$config['api_domain'] = 'maps.google.com';