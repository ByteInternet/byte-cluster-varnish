<?php
/**
 * Terebinth Component
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/

defined('_JEXEC') or die;
?>

    <fieldset class="batch">
        <legend><?php echo JText::_('COM_TEREBINTH_HEADING_PURGE_TEREBINTHES'); ?></legend>
        <button type="button" onclick="this.form.task.value='terebinthes.purgeall';this.form.submit();"><?php echo JText::_('COM_TEREBINTH_BUTTON_PURGE_TEREBINTHES'); ?></button>
    </fieldset>
