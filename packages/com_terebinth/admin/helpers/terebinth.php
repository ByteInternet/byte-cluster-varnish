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
        /* This method "walks" down a URI, purging things along the way */

        $url = explode('/', $url);
        foreach( $url as $partial_url )
        {
            if (count($url) == 1)
            {
                $purge_url = "/";
            } else {
                $purge_url = implode($url, '/');
                array_pop($url);
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

        $finalURL = "http://" . $terebinth_host . $url;
        $curlOptionList = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PURGE',
            CURLOPT_HEADER => true ,
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
