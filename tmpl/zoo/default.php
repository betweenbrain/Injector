<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    3/19/14 3:20 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
$elements = json_decode($item->elements);
$params = json_decode($item->params);
?>
	<h1><?php echo $item->name ?></h1>
	<dl class="article-info">
		<dd class="createdby">
			<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $item->created_by_alias); ?>
		</dd>
		<dd class="create">
			<span class="icon-calendar"></span> <?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'))); ?>
		</dd>
		<dd class="category-name">
			<?php echo JText::sprintf('COM_CONTENT_CATEGORY', htmlspecialchars($params->{'config.primary_category'})); ?>
		</dd>
		<dd class="modified">
			<span class="icon-calendar"></span> <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
		</dd>
		<dd class="hits">
			<span class="icon-eye-open"></span> <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
		</dd>
	</dl>
<?php foreach ($elements as $element)
{
	if (property_exists($element, 'file')) : ?>
		<img src="<?php echo $element->file ?>" />
	<?php endif;

	if (property_exists($element, '0'))
	{
		array_walk($element, function (&$value)
		{
			echo $value->value;
		});
	}
}
