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

exec("git merge develop");