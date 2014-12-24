<?php
/*
 * Plugin Name: Varnish Cache
 * Description: Append a generic varnish cache support to your WordPress domain.
 * Author: 42functions
 * Version: 1.0
 * Author URI: http://42functions.nl/
 */



require_once dirname(__FILE__) . '/build.methods.php';

require_once dirname(__FILE__)  . '/class/pattern.singleton.php';
require_once dirname(__FILE__)  . '/class/manager.module.php';
require_once dirname(__FILE__)  . '/class/facade.cache.php';


XLII_Cache_Manager::init();