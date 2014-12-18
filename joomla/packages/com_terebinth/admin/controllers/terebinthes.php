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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Terebinthes Controller
 */
class TerebinthControllerTerebinthes extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Terebinth', $prefix = 'TerebinthModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

    public function purgeall()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get the model.
        $model = $this->getModel();

        // Initialise variables.
        $ids        = JRequest::getVar('cid', array(), '', 'array');

        if (empty($ids)) {
            JError::raiseWarning(500, JText::_('COM_TEREBINTH_NO_SERVERS_SELECTED'));
        } else {
            JArrayHelper::toInteger($ids);
            
            // purge the server
            if (!$model->purge($ids)) {
                JError::raiseWarning(500, $model->getError());
            } else {
                $this->setMessage(JText::plural('COM_TEREBINTH_N_SERVERS_PURGED', count($ids)));
            }
        }

        $this->setRedirect('index.php?option=com_terebinth&view=terebinthes');

    }

}
