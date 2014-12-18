<?php
/**
 * Terebinth Content Plugin
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_ADMINISTRATOR . '/components/com_terebinth/helpers/terebinth.php');
include_once JPATH_SITE . '/components/com_content/helpers/route.php';


class plgContentTerebinth extends JPlugin
{

    function onContentAfterDelete($context, $data)
    {
        if (!$this->params->def('onContentAfterDelete'))
        {
            return true;
        }
        return true;
    }

    function onContentBeforeSave($context, $article, $isNew)
    {
        $newURL = "/";
        if (!$this->params->def('onContentBeforeSave'))
        {
            return true;
        }

        jimport('joomla.application.router');

        switch($context) {
            case "com_content.article":
                $URL = ContentHelperRoute::getArticleRoute($article->id .":". $article->alias, $article->catid);
                $config = JFactory::getConfig();
                $router = JRouter::getInstance('site');
                $router->setMode($config->get('sef',1));
                $newURL = $router->build($URL)->toString(array('path', 'query', 'fragment'));
                $base = JURI::base(true);
                if (JString::strpos($newURL, $base) !== 0)
                {
                    throw new Exception('Unexpected route.');
                }
                $newURL = JString::substr($newURL, JString::strlen($base));
                break;
            case "com_media.file":
                $filepath = $article->filepath;
                $base = JPATH_SITE;
                if (JString::strpos($filepath, $base) !== 0)
                {
                    throw new Exception('Unexpected path.');
                }
                $newURL = JString::substr($filepath, JString::strlen($base));
                break;
            default:
                $newUrl = "/";
                break;
        }

        Terebinth::walk_purge($newURL);
        return true;
    }
}


?>
