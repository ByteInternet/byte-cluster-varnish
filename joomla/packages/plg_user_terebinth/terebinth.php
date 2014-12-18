<?php
/**
 * Terebinth User Plugin
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/


defined('JPATH_BASE') or die;

class plgUserTerebinth extends JPlugin
{
    function onUserLogin($user, $options)
    {
        // set "loggedin" session cookie
        setcookie("loggedin","true", 0, '/', null, null, true );
    }

    function onUserLogout($user, $options)
    {
        // remove "loggedin" session cookie
        setcookie("loggedin", "", time()-3600, '/', null, null, true);
    }
}
