<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Capture logs
 */
Event::add('system.log', array('DebugToolbar', 'log'));
?>