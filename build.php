#!/usr/bin/php
<?php
PHP_SAPI === 'cli' or die();

/**
 * File       build.php
 * Created    11/21/14 4:51 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */

echo 'Merging develop branch' . PHP_EOL;
exec("git merge --no-commit develop");

echo 'Removing README.md' . PHP_EOL;
unlink('README.md');

echo 'Removing /plugins' . PHP_EOL;
recursiveRemoveDirectory(dirname(__FILE__) . '/plugins');

function recursiveRemoveDirectory($directory)
{
	foreach (glob("{$directory}/*") as $file)
	{
		if (is_dir($file))
		{
			recursiveRemoveDirectory($file);
		}
		else
		{
			unlink($file);
		}
	}
	rmdir($directory);
}
