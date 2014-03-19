<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    3/17/14 10:13 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

?>
<h1><?php echo $item->title ?></h1>
<p><?php echo $item->introtext ?></p>
<?php if (isset($item->extraFields))
{
	foreach ($item->extraFields as $extraField)
	{
		echo $extraField->name . ': ' . $extraField->value;
	}
}