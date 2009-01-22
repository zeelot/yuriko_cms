<?php
Event::add('system.pre_controller', array('notice', 'load'));
Event::add('system.redirect', array('notice', 'save'));
