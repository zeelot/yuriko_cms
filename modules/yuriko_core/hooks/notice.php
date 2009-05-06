<?php defined('SYSPATH') OR die('No direct access allowed.');

Event::add('system.pre_controller', array('notice', 'load'));
//save the unused notices right before headers are sent or user is redirected
Event::add('system.send_headers', array('notice', 'save'));
Event::add('system.redirect', array('notice', 'save'));
