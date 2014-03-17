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

	/**
	 * Constructor.
	 *
	 * @param   object &$subject The object to observe
	 * @param   array  $config   An optional associative array of configuration settings.
	 *
	 * @since   0.1
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->app = JFactory::getApplication();
		$this->db  = JFactory::getDbo();

	}

	/**
	 * @return bool
	 */
	function onAfterRender()
	{

		if ($this->app->isAdmin())
		{
			return true;
		}

		$buffer = JResponse::getBody();

		// Match title tag
		$buffer = preg_replace_callback(
			'/{k2item ([0-9]*)}/i',
			function ($matches)
			{
				include_once 'components/com_k2/models/item.php';

				$K2ModelItem = new K2ModelItem();

				// K2ModelItem->getData() looks for ID parameter
				JRequest::setVar('id', $matches[1]);

				$item = $K2ModelItem->getData();
				// Attached extra fields to $item
				$K2ModelItem->getItemExtraFields($item->extra_fields, $item);

				//$itemTags        = $K2ModelItem->getItemTags($matches[1]);

				//die('<pre>' . print_r($item, true) . '</pre>');

				ob_start();
				include_once 'tmpl/default.php';

				return ob_get_clean();

			},
			$buffer
		);

		JResponse::setBody($buffer);

		return true;

	}
}
