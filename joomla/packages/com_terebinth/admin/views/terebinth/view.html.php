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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Terebinth View
 */
class TerebinthViewTerebinth extends JViewLegacy
{
	/**
	 * display method of Terebinth view
	 * @return void
	 */
  protected $form = null;

	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		$script = $this->get('Script');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
		$this->script = $script;

		// Set the toolbar
		$this->addToolBar();


		// Display the template
		parent::display($tpl);

    // Set the document
    $this->setDocument();

	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
    $input = JFactory::getApplication()->input;

    // Hide Joomla Administrator Main Menu
    $input->set('hidemainmenu', true);

    $isNew = ($this->item->id == 0);
    if ($isNew)
    {
      $title = JText::_('COM_TEREBINTH_MANAGER_TEREBINTH_NEW');
    }
    else
    {
      $title = JText::_('COM_TEREBINTH_MANAGER_TEREBINTH_EDIT');
    }

    JToolBarHelper::title($title, 'terebinth');
    JToolBarHelper::save('terebinth.save');
    JToolBarHelper::cancel('terebinth.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_TEREBINTH_TEREBINTH_CREATING') : JText::_('COM_TEREBINTH_TEREBINTH_EDITING'));
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_terebinth/views/terebinth/submitbutton.js");
		JText::script('COM_TEREBINTH_TEREBINTH_ERROR_UNACCEPTABLE');
	}
}
