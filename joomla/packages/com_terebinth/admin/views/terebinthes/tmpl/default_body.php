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
?>
<?php if (!empty($this->items)) : ?>
  <?php foreach($this->items as $i => $item) :
    $link = JRoute::_('index.php?option=com_terebinth&task=terebinth.edit&id=' . $item->id);
  ?>
  <tr>
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_TEREBINTH_EDIT_TEREBINTH'); ?>">
				<?php echo $item->terebinth_host; ?>
			</a>
		</td>
	</tr>
  <?php endforeach; ?>
<?php endif; ?>
