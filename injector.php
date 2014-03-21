<?php defined('_JEXEC') or die;

/**
 * File       injector.php
 * Created    3/12/14 3:02 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
class plgSystemInjector extends JPlugin
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

		preg_match_all('/{([a-zA-Z0-9_-]*)-item ([0-9]*)\s?([a-zA-Z]*)?}/i', $buffer, $matches, PREG_SET_ORDER);

		foreach ($matches as $match)
		{
			$buffer = str_replace($match[0], $this->replaceMatch($match[1], $match[2], $match[3]), $buffer);
		}

		JResponse::setBody($buffer);

		return true;

	}

	/**
	 * Retrieves and renders the matched ID number given the designated template
	 *
	 * @param      $id
	 * @param null $template
	 *
	 * @return string
	 */
	private function replaceMatch($component, $id, $template = null)
	{
		switch ($component)
		{
			case('content'):
				require_once JPATH_ROOT . '/components/com_content/models/article.php';

				$ContentModelArticle = new ContentModelArticle;
				$item                = $ContentModelArticle->getItem($id);

				break;

			case('k2'):
				require_once JPATH_ROOT . '/components/com_k2/models/item.php';

				// K2ModelItem->getData() looks for ID parameter
				JRequest::setVar('id', $id);

				$K2ModelItem        = new K2ModelItem;
				$item               = $K2ModelItem->getData();
				$item->extra_fields = $K2ModelItem->getItemExtraFields($item->extra_fields, $item);

				break;

			case('zoo'):

				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query
					->select('*')
					->from($db->quoteName('#__zoo_item'));

				$db->setQuery($query);

				$item = $db->loadObject();

				break;
		}

		ob_start();

		if ($template && file_exists(
				$override = JPATH_BASE . '/templates/' . $this->app->getTemplate() . '/html/plg_injector/' . $component . '/' . $template . '/default.php')
		)
		{
			include $override;
		}
		else
		{
			include dirname(__FILE__) . '/tmpl/' . $component . '/default.php';
		}

		return ob_get_clean();
	}
}
