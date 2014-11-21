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

define('BASEDIR', dirname(__FILE__));

echo 'Merging develop branch...' . PHP_EOL;
exec("git merge develop");

echo 'Cleaning up old release files...' . PHP_EOL;

// Delete old archive files
foreach (glob('{*.zip, *.tar, *.tar.gz}', GLOB_BRACE) as $filename)
{
	echo 'Removing ' . $filename . PHP_EOL;
	unlink(BASEDIR . $filename);
}

//
foreach (glob(BASEDIR . '/plugins/*', GLOB_ONLYDIR) as $dir)
{

	///home/mthomas/public_html/dev/extensions/Injector/plugins/ajax/injector/injector.xml
	$manifest = new SimpleXMLElement(file_get_contents($dir . '/injector/injector.xml'));

	echo $manifest->version . PHP_EOL;

	$filename = 'Injector-' . basename($dir) . '-' . $manifest->version . '.tar';

	if (file_exists($filename))
	{
		unlink($filename);
		echo 'Deleted ' . $filename . PHP_EOL;
	}

	if (file_exists($filename . '.gz'))
	{
		unlink($filename . '.gz');
		echo 'Deleted ' . $filename . '.gz' . PHP_EOL;
	}

	try
	{

		$a = new PharData($filename);

		// ADD FILES TO archive.tar FILE
		$a->buildFromDirectory($dir . '/injector');

		// COMPRESS archive.tar FILE. COMPRESSED FILE WILL BE archive.tar.gz
		//$a->compress(Phar::GZ);

		// NOTE THAT BOTH FILES WILL EXISTS. SO IF YOU WANT YOU CAN UNLINK archive.tar
		//unlink($filename);
	} catch (Exception $e)
	{
		echo "Exception : " . $e;
	}

	//echo basename($dir . PHP_EOL);
}
