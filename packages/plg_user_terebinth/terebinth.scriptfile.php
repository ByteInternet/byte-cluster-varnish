<?php
/**
 * Terebinth User Plugin
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of JFUploader plugin
 */
class plgUserTerebinthInstallerScript
{
  function install($parent) {
     // I activate the plugin
    $db = JFactory::getDbo();
     $tableExtensions = $db->quoteName("#__extensions");
     $columnElement   = $db->quoteName("element");
     $columnType      = $db->quoteName("type");
     $columnEnabled   = $db->quoteName("enabled");

     // Enable plugin
     $db->setQuery("UPDATE $tableExtensions SET $columnEnabled=1 WHERE $columnElement='terebinth' AND $columnType='plugin'");
     $db->query();

     echo '<p>'. JText::_('PLG_USER_TEREBINTH_PLUGIN_ENABLED') .'</p>';
  }
}
?>

