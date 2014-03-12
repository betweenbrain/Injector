<?php defined('_JEXEC') or die;

/**
 * File       k2_injector.php
 * Created    3/12/14 3:02 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */
class plgSystemK2_injector extends JPlugin
{

	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	function onAfterRender()
	{

		$app = JFactory::getApplication();

		if ($app->isAdmin())
		{
			return true;
		}

		$buffer = JResponse::getBody();

		// Match title tag
		preg_match('/{k2item ([0-9]*)}/i', $buffer, $matches);

		if (array_key_exists('1', $matches))
		{
			$buffer = print_r($matches[1], true) . $buffer;
		}

		JResponse::setBody($buffer);

		return true;

	}
}
