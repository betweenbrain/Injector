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

echo 'Merging develop branch...' . PHP_EOL;
exec("git merge develop");

echo 'Cleaning up old release files...' . PHP_EOL;
foreach (glob('{*.zip, *.tar.gz}', GLOB_BRACE) as $filename)
{
	echo 'Removing ' . $filename . PHP_EOL;
	unlink(dirname(__FILE__) . $filename);
}
