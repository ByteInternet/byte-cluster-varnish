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
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');

// load tooltip behavior
//JHtml::_('behavior.tooltip');
?>

<form action="index.php?option=com_terebinth&view=terebinthes" method="post" id="adminForm" name="adminForm">
  <table class="table table-striped table-hover">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	</table>

    <?php if (!empty($this->items)) : ?>
        <?php echo $this->loadTemplate('purgeform'); ?>
    <?php endif; ?>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
