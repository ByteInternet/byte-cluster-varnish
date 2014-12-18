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

// set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-terebinth {background-image: url(../media/com_terebinth/images/terebinth-48x48.png);}');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Terebinth
$controller = JControllerLegacy::getInstance('Terebinth');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
