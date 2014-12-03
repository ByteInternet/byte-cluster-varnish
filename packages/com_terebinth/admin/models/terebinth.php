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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Terebinth Model
 */
class TerebinthModelTerebinth extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Terebinth', $prefix = 'TerebinthTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_terebinth.terebinth', 'terebinth', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	public function getScript() 
	{
		return 'administrator/components/com_terebinth/models/forms/terebinth.js';
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_terebinth.edit.terebinth.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}

    public function purge(&$pks)
    {

        $user   = JFactory::getUser();

        // Sanitize the ids.
        $pks = (array) $pks;
        JArrayHelper::toInteger($pks);

        // Access checks.
        if (!$user->authorise('core.edit', 'com_terebinth')) {
            $pks = array();
            $this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
            return false;
        }

        $table = $this->getTable();

        if (!empty($pks))
        {
            foreach($pks as $pk)
            {
                if(!$table->load($pk))
                {
                    $this->setError($table->getError());
                    return false;
                } else {
                    if (!$this->terebinth_ban($table->terebinth_host))
                    {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    protected function terebinth_ban($terebinth_host)
    {
        $URL = "http://" . $terebinth_host;
        $curlOptionList = array(
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_CUSTOMREQUEST   =>  'BAN',
            CURLOPT_HEADER          =>  true,
            CURLOPT_NOBODY          =>  true,
            CURLOPT_URL             =>  $URL,
            CURLOPT_CONNECTTIMEOUT_MS   =>  2000,
        );

        $curlHandler = curl_init();
        curl_setopt_array( $curlHandler, $curlOptionList );
        curl_exec( $curlHandler );
        if(curl_errno($curlHandler))
        {
            $this->setError(curl_error($curlHandler));
            curl_close( $curlHandler );
            return false;
        }

        curl_close( $curlHandler );
        return true;
    }
}
