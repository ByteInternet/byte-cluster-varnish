<?php
/**
 * Terebinth Component
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_terebinth/models', 'TerebinthModel');

class Terebinth {
    public static function write_debug($filename, $data)
    {
        file_put_contents($filename, $data);
    }

    public static function walk_purge($url)
    {
        
        /* Byte/WdG 20141128 Purge also wildcard/title */
        $tokens = explode('/', $url);
        # at least 2 slashes
        if (count($tokens) > 2) {
            $purge_url = '/.+/' . array_pop($tokens); 
            Terebinth::purge($purge_url);
        }

        /* This method "walks" down a URI, purging things along the way */
        $tokens = explode('/', $url);
        foreach( $tokens as $partial_url )
        {
            if (count($tokens) == 1)
            {
                $purge_url = "/";
            } else {
                $purge_url = implode($tokens, '/');
                array_pop($tokens);
            }
            Terebinth::purge($purge_url);
        }       
    }

    public static function purge($url)
    {
        /* Accepts a string, and purges that URL from all defined cache servers */

        $vmodel = JModelLegacy::getInstance('Terebinthes', 'TerebinthModel');
        $items = $vmodel->getItems();
        foreach( $items as $item)
        {
            Terebinth::purge_url($item->terebinth_host, $url);
        }
        return true;
    }

    protected static function purge_url($terebinth_host, $url)
    {
        /* This one actually does the http purge request */

        if (empty($_SERVER["HTTP_X_ORIGINAL_SERVER_IP"])) {
            return true;
        }

        $finalURL = "http://" . $_SERVER["HTTP_X_ORIGINAL_SERVER_IP"] . $url;
        $curlOptionList = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PURGE',
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array('Host: '.$_SERVER["HTTP_HOST"]),
            CURLOPT_NOBODY => true,
            CURLOPT_URL => $finalURL,
            CURLOPT_CONNECTTIMEOUT_MS => 2000
        );

        $curlHandler = curl_init();
        curl_setopt_array( $curlHandler, $curlOptionList );
        curl_exec( $curlHandler );
        if(curl_errno($curlHandler))
        {
            curl_close( $curlHandler );
            return false;
        }
        curl_close( $curlHandler );
        return true;
    }
}
