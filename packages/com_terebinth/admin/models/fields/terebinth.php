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
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Terebinth Form Field class for the Terebinth component
 */
class JFormFieldTerebinth extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Terebinth';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,terebinth_host');
		$query->from('#__terebinth');
		$db->setQuery((string)$query);
		$terebinth_hosts = $db->loadObjectList();
		$options = array();
		if ($terebinth_hosts)
		{
			foreach($terebinth_hosts as $host) 
			{
				$options[] = JHtml::_('select.option', $host->id, $host->terebinth_host);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
