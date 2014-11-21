<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    3/19/14 3:20 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
$images = json_decode($item->images);
?>
<h1><?php echo $item->title ?></h1>
<dl class="article-info">
	<dd class="createdby">
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $item->created_by_alias); ?>
	</dd>
	<dd class="create">
		<span class="icon-calendar"></span> <?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'))); ?>
	</dd>
	<dd class="parent-category-name">
		<?php echo JText::sprintf('COM_CONTENT_PARENT', htmlspecialchars($item->parent_title)); ?>
	</dd>
	<dd class="category-name">
		<?php echo JText::sprintf('COM_CONTENT_CATEGORY', htmlspecialchars($item->category_title)); ?>
	</dd>
	<dd class="modified">
		<span class="icon-calendar"></span> <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
	</dd>
	<dd class="hits">
		<span class="icon-eye-open"></span> <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
	</dd>
</dl>

<?php if (isset($images->image_fulltext) && !empty($images->image_fulltext)) : ?>
	<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"><img
			<?php if ($images->image_fulltext_caption):
				echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"';
			endif; ?>
			src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" />
	</div>
<?php endif; ?>

<p><?php echo $item->introtext ?></p>