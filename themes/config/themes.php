<?php

/**
 * Driver to use for storage of available and active themes.
 * For now only ORM is available.
 */
$config['driver'] = 'ORM';

$config['active'] = array
(
  'name'    => 'default',
  'title'   => "Default Theme",
  'dir'     => 'default',
);
$config['default'] = array
(
  'name'    => 'default',
  'title'   => "Default Theme",
  'dir'     => 'default',
);

$config['available'] = array
(
  'default'                   => array
  (
    'name'    => 'default',
    'title'   => "Default Theme",
    'dir'     => 'default',
  ),
  'zeelots_sandbox'           => array
  (
    'name'    => 'zeelots_sandbox',
    'title'   => "Zeelot's Sandbox Theme",
    'dir'     => 'zeelots_sandbox',
  ),
  'zeelots_other_theme'       => array
  (
    'name'    => 'zeelots_other_theme',
    'title'   => "Zeelot's Other Theme",
    'dir'     => 'zeelots_other_theme',
  ),
);
