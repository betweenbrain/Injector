<?php defined('_JEXEC') or die;

/**
 * File       response.php
 * Created    3/27/14 8:46 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
?>
<form action="<?php echo JRoute::_('index.php?option=com_ajax&plugin=injector&format=html&function=AjaxSelectItem&tmpl=component') ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<fieldset class="filter clearfix">
		<div class="btn-toolbar">
			<?php echo JHtml::_('select.genericlist', $options, 'filter_component', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $component); ?>
		</div>
		<div class="filters pull-left">
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	</fieldset>
	<table class="table table-striped table-condensed">
		<thead>
		<?php
		foreach ($fields as $field) : ?>
			<th>
				<?php echo ucfirst($field) ?>
			</th>
		<?php endforeach ?>
		</thead>
		<tfoot>
		<tr>
			<td colspan="15">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo htmlspecialchars($function); ?>('<?php echo $item->id; ?>', '<?php echo $component; ?>');">
						<?php echo htmlspecialchars($item->title); ?></a>
				</td>
				<td>
					<?php echo htmlspecialchars($item->viewlevel); ?>
				</td>
				<td>
					<?php echo htmlspecialchars($item->category); ?>
				</td>
				<?php if(array_key_exists('created', $item)) : ?>
				<td>
					<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				<?php endif ?>
				<td>
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>
