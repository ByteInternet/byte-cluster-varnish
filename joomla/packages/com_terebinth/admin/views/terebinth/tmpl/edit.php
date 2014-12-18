<?php
/**
 * Terebinth Component
 *
 * Copyright (c) 2013 Nicholas Wheeler
 *
 * @license GNU / GPL 
 *   
**/


// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
?>

<form action="<?php echo JRoute::_('index.php?option=com_terebinth&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
  <div class="form-horizontal">
	  <fieldset class="adminform">
		  <legend><?php echo JText::_( 'COM_TEREBINTH_TEREBINTH_DETAILS' ); ?></legend>
        <div class="row-fluid">
          <div class="span6">
            <?php foreach ($this->form->getFieldset() as $field): ?>
              <div class="control-group">
                <div class="control-label"><?php echo $field->label; ?></div>
                <div class="controls"><?php echo $field->input; ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </fieldset>
    </div>
    <input type="hidden" name="task" value="terebinth.edit" />
		<?php echo JHtml::_('form.token'); ?>
</form>
