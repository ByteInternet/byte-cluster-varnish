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

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Terebinth Controller
 */
class TerebinthControllerTerebinth extends JControllerForm
{
    function __construct($config = array()) {
      $this->view_list = 'terebinthes';
      parent::__construct($config);
    }
}
