<?php defined('_JEXEC') or die;

/**
 * File       injector.php
 * Created    3/27/14 2:27 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */

// Import library dependencies
jimport('joomla.plugin.plugin');
// Pagination class
JLoader::import('joomla.html.pagination');
// Pagniation dependencies
JHtml::_('behavior.tooltip');

class plgAjaxInjector extends JPlugin
{

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

	function onAjaxInjector()
	{
		// Form controls
		$option     = $this->app->input->get('plugin');
		$component  = $this->app->getUserStateFromRequest($option . '_filter_component', 'filter_component', 'content', 'string');
		$function   = $this->app->input->get('function', 'AjaxSelectItem');
		$limit      = $this->app->getUserStateFromRequest($option . '_limit', 'limit', $this->app->getCfg('list_limit'), 'int');
		$limitstart = $this->app->getUserStateFromRequest($option . '_limitstart', 'limitstart', 0, 'int');
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		// Supported components, used at plugins/ajax/injector/response.php:15
		$options = array(
			'content' => 'Content',
		);

		if (JComponentHelper::isEnabled('com_k2', true))
		{
			$options['k2'] = 'K2';
		}
		if (JComponentHelper::isEnabled('com_zoo', true))
		{
			$options['zoo'] = 'Zoo';
		}

		// Create a new query objects
		$query      = $this->db->getQuery(true);
		$limitQuery = $this->db->getQuery(true);

		// Queried database fields
		$fields = array(
			'title',
			'access',
			'category',
			'created',
			'id'
		);

		switch ($component)
		{
			case('content'):
				$query
					->select($this->db->quoteName(array(
						'content.title',
						'content.access',
						'content.catid',
						'content.created',
						'categories.id',
						'viewlevels.id',
						'content.id',
						'categories.extension')))
					->select($this->db->quoteName('categories.title', 'category'))
					->select($this->db->quoteName('viewlevels.title', 'viewlevel'))
					->from($this->db->quoteName('#__content', 'content'))
					->join('LEFT', $this->db->quoteName('#__categories', 'categories') . ' ON (' . $this->db->quoteName('content.catid') . ' = ' . $this->db->quoteName('categories.id') . ')')
					->join('LEFT', $this->db->quoteName('#__viewlevels', 'viewlevels') . ' ON (' . $this->db->quoteName('content.access') . ' = ' . $this->db->quoteName('viewlevels.id') . ')')
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1') . ' AND ' . $this->db->quoteName('categories.extension') . ' = ' . $this->db->quote('com_' . $component))
					->order($this->db->quoteName('content.title') . ' ASC');

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__content'))
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1'));

				require_once JPATH_ROOT . '/components/com_content/helpers/route.php';
				break;

			case('k2'):
				$query
					->select($this->db->quoteName(array(
						'k2_items.title',
						'k2_items.access',
						'k2_items.catid',
						'k2_items.created',
						'k2_categories.id',
						'viewlevels.id',
						'k2_items.id')))
					->select($this->db->quoteName('k2_categories.name', 'category'))
					->select($this->db->quoteName('viewlevels.title', 'viewlevel'))
					->from($this->db->quoteName('#__k2_items', 'k2_items'))
					->join('LEFT', $this->db->quoteName('#__k2_categories', 'k2_categories') . ' ON (' . $this->db->quoteName('k2_items.catid') . ' = ' . $this->db->quoteName('k2_categories.id') . ')')
					->join('LEFT', $this->db->quoteName('#__viewlevels', 'viewlevels') . ' ON (' . $this->db->quoteName('k2_items.access') . ' = ' . $this->db->quoteName('viewlevels.id') . ')')
					->where($this->db->quoteName('k2_items.trash') . ' = ' . $this->db->quote('0'))
					->order($this->db->quoteName('k2_items.title') . ' ASC');

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__k2_items'));

				break;

			case('zoo'):
				$query
					->select($this->db->quoteName(array(
						'zoo_item.access',
						'zoo_item.created',
						'zoo_application.id',
						'viewlevels.id',
						'zoo_item.id')))
					->select($this->db->quoteName('zoo_item.name', 'title'))
					->select($this->db->quoteName('zoo_item.application_id', 'catid'))
					->select($this->db->quoteName('zoo_application.name', 'category'))
					->select($this->db->quoteName('viewlevels.title', 'viewlevel'))
					->from($this->db->quoteName('#__zoo_item', 'zoo_item'))
					->join('LEFT', $this->db->quoteName('#__zoo_application', 'zoo_application') . ' ON (' . $this->db->quoteName('zoo_item.application_id') . ' = ' . $this->db->quoteName('zoo_application.id') . ')')
					->join('LEFT', $this->db->quoteName('#__viewlevels', 'viewlevels') . ' ON (' . $this->db->quoteName('zoo_item.access') . ' = ' . $this->db->quoteName('viewlevels.id') . ')')
					->where($this->db->quoteName('zoo_item.state') . ' = ' . $this->db->quote('1'))
					->order($this->db->quoteName('zoo_item.name') . ' ASC');

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__zoo_item'));

				break;
		}

		$this->db->setQuery($query, $limitstart, $limit);
		$this->items = $this->db->loadObjectList();

		$this->db->setQuery($limitQuery);
		$total = $this->db->loadResult();

		$this->pagination = new JPagination($total, $limitstart, $limit);

		// Start output buffering
		ob_start();

		include JPATH_PLUGINS . '/ajax/injector/response.php';

		// Return output buffer
		return ob_get_clean();
	}
}
