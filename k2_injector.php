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

				$itemData = $K2ModelItem->getData();
				$itemTags = $K2ModelItem->getItemTags($matches[1]);
				$itemExtraFields =  $K2ModelItem->getItemExtraFields($itemData->extra_fields, $itemData);

				die('<pre>' . print_r($itemExtraFields, true) . '</pre>');

				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query
					->select($db->quoteName(array('title', 'introtext', 'fulltext')))
					->from($db->quoteName('#__k2_items'))
					->where($db->quoteName('id') . ' = ' . $db->quote($matches[1]) . ' AND ' . $db->quoteName('trash') . ' = ' . $db->quote('0'));

				$db->setQuery($query);

				$result = $db->loadObject();

				$return = '<h2>' . $result->title . '</h2>';
				$return .= '<p>' . $result->introtext . '</p>';

				return $return;
			},
			$buffer
		);

		JResponse::setBody($buffer);

		return true;

	}
}
