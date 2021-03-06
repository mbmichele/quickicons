<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_akquickicons
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

include_once AKPATH_COMPONENT.'/modellist.php' ;

/**
 * Methods supporting a list of Akquickicons records.
 */
class AkquickiconsModelIcons extends AKModelList
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected 	$text_prefix = 'COM_AKQUICKICONS';
	
	public 		$component = 'akquickicons' ;
	public 		$item_name = 'icon' ;
	public 		$list_name = 'icons' ;
	
	
    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
		
		// Set query tables
		// ========================================================================
		$config['tables'] = array(
			'a' => '#__akquickicons_icons',
			'b' => '#__categories',
			'c' => '#__users',
			'd' => '#__viewlevels',
			'e' => '#__languages'
		);
		
		
		
		// Set filter fields
		// ========================================================================
        if (empty($config['filter_fields'])) {
			$select = JRequest::getVar('select') ;
			
			if($select) {
				if($select == 'modules') {
					
					$config['filter_fields'] = array(
						'filter_order_Dir', 'filter_order',
						'a.title', 'a.position', 'b.name', 'b.client_id'
					);
					
				}elseif($select == 'plugins') {
					
					$config['filter_fields'] = array(
						'filter_order_Dir', 'filter_order',
						'a.name', 'a.folder', 'a.element'
					);
					
				}elseif($select == 'articles') {
					
					$config['filter_fields'] = array(
						'filter_order_Dir', 'filter_order',
						'a.title', 'a.catid', 'a.created'
					);
				}	
			}else{
					
				$config['filter_fields'] = array(
					'filter_order_Dir', 'filter_order'
				);
				
				$config['filter_fields'] = AkquickiconsHelper::_('db.mergeFilterFields', $config['filter_fields'] , $config['tables'] );
				
			}
            
        }
		
		
		
		// Other settings
		// ========================================================================
		$config['fulltext_search'] 	= true ;
		
		$config['core_sidebar'] 	= false ;
		
		
		$this->config = $config ;
		
        parent::__construct($config);
    }

	
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app 	= JFactory::getApplication() ;
		$select = JRequest::getVar('select') ;
		
		if($select) {
			$origin_search = $app->getUserState($this->context.'.field.search');
		}
		
		
		// Set First order field
		$this->setState('list.orderingPrefix', array('a.catid')) ;
		
		
		parent::populateState($ordering, $direction);
		
		
		
		// Set all filter fields
		// ========================================================================
		
		$select = $select ? '.'.$select : '' ;
		
		$filter = $app->getUserStateFromRequest($this->context.'.field'.$select.'.filter', 'filter');
		$filter_fields = array();
		foreach( $this->filter_fields as $field ){
			$filter_fields[$field] = JArrayHelper::getValue($filter, $field, '') ;
		}
		$this->setState('filter', $filter_fields );
		
		
		$search = $app->getUserStateFromRequest($this->context.'.field'.$select.'.search', 'search');
		if(in_array(JArrayHelper::getValue($search, 'field'), $this->filter_fields) || $this->config['fulltext_search']){
			$this->setState('search', $search );
		}
		
		if($select) {
			$app->setUserState($this->context.'.field.search', $origin_search) ;
		}
	}

	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		return parent::getStoreId($id);
	}
	
	
	/**
	 * Method to get list page filter form.
	 *
	 * @return	object		JForm object.
	 * @since	2.5
	 */
	
	public function getFilter()
	{
		$filter = parent::getFilter();
		
		return $filter ;
	}
	
	

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Get some data
		// ========================================================================
		
		// Create a new query object.
		$db			= $this->getDbo();
		$q			= $db->getQuery(true);
		$order 		= $this->getState('list.ordering' , 'a.id');
		$dir		= $this->getState('list.direction', 'asc');
		$prefix 	= $this->getState('list.orderingPrefix', array()) ;
		$orderCol	= $this->getState('list.orderCol','a.ordering') ;

		// Filter and Search
		$filter = $this->getState('filter',array()) ;
		$search = $this->getState('search') ;
		$wheres = $this->getState('query.where', array()) ;
		$having = $this->getState('query.having', array()) ;
		
		$layout = JRequest::getVar('layout') ;
		$nested = $this->getState('items.nested') ;
		$avoid	= JRequest::getVar('avoid') ;
		$show_root = JRequest::getVar('show_root') ;
		
		
		
		// Nested
		// ========================================================================
		if($nested && !$show_root){
			$q->where("a.id != 1") ;
		}
		
		if($avoid){
			$table = $this->getTable();
			$table->load( $avoid ) ;
			
			$q->where("a.lft < {$table->lft} OR a.rgt > {$table->rgt}") ;
			$q->where("a.id != {$avoid}") ;
		}
		
		
		
		// Search
		// ========================================================================
		if($search['index']){
			
			if($this->getState( 'search.fulltext' )){
				$fields = $this->getFullSearchFields();
				
				foreach( $fields as &$field ):
					$field = "{$field} LIKE '%{$search['index']}%'" ;
				endforeach;
				
				if(count($fields))
				$q->where( "( ".implode(' OR ', $fields )." )" );
				
			}else{
				$q->where("{$search['field']} LIKE '%{$search['index']}%'");
			}
			
		}
		
		
		
		// Filter
		// ========================================================================
		foreach($filter as $k => $v ){
			if($v !== '' && $v != '*'){
				$q->where("{$k}='{$v}'") ;
			}
		}
		
		// published
		if(empty($filter['a.published'])){
			$q->where("a.published >= 0") ;
		}
		
		
		// Ordering
		// ========================================================================
		if( $orderCol == $order ){
			$prefix = count($prefix) ? implode(', ', $db->qn($prefix)) . ', ' : '' ;
		}else{
			$prefix = '' ;
		}
		
		$order = $db->qn($order);
		
		
		// Build query
		// ========================================================================
		
		// get select columns
		$select = AkquickiconsHelper::_( 'db.getSelectList', $this->config['tables'] );
		
		//build query
		$q->select($select)
			->from('#__akquickicons_icons AS a')
			->leftJoin('#__categories 	AS b ON a.catid = b.id')
			->leftJoin('#__users 		AS c ON a.created_by = c.id')
			->leftJoin('#__viewlevels 	AS d ON a.access = d.id')
			->leftJoin('#__languages 	AS e ON a.language = e.lang_code')
			//->where("")
			->order( "{$prefix}{$order} {$dir}" ) ;
		
		return $q;
	}
	
	
	/*
	 * function getMenus
	 * @param 
	 */
	
	public function getModules()
	{
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');
		$limit 	= $this->getState('list.limit');
		$start 	= $this->getState('list.start');
		
		// Filter and Search
		$filter = $this->getState('filter',array()) ;
		$search = $this->getState('search') ;
		$layout = JRequest::getVar('layout') ;
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		
		// Search
		// ========================================================================
		if($search['index']){
			$q->where("a.title LIKE '%{$search['index']}%'");
		}
		
		
		// Filter
		// ========================================================================
		if(!empty($filter['b.client_id'])) {
			$q->where('b.client_id='.$filter['b.client_id']);
		}else{
			$q->where('b.client_id=0');
		}
		
		
		$q->select("a.*, b.*,a.id AS id, a.title AS title, b.name AS name")
			->from("#__modules AS a")
			->join('LEFT', '#__extensions AS b ON b.element = a.module')
			//->where("a.menutype = 'menu'")
			->order( " {$order} {$dir}" ) ;
			;
		
		$db->setQuery($q);
		$result = $db->loadObjectList();
		
		$result = $result ? $result : array();
		
		foreach( $result as &$row ):
			$row->link = 'index.php?option=com_modules&task=module.edit&id='.$row->id;
		endforeach;
		
		return $result ;
	}
	
	
	/*
	 * function getMenus
	 * @param 
	 */
	
	public function getPlugins()
	{
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');
		$limit 	= $this->getState('list.limit', 20);
		$start 	= $this->getState('list.start', 0);

		// Filter and Search
		$search = $this->getState('search') ;
		$layout = JRequest::getVar('layout') ;
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		
		$q->select("a.*, a.name AS title, a.extension_id AS id")
			->from("#__extensions AS a")
			
			->where("a.type = 'plugin'")
			->order( " {$order} {$dir}" ) ;
			;
		
		$db->setQuery($q);
		$result = $db->loadObjectList();
		
		$result = $result ? $result : array();
		
		
		foreach( $result as &$row ):
			$row->link = 'index.php?option=com_plugins&task=plugin.edit&extension_id='.$row->id;
		endforeach;
		
		
		return $result ;
	}
	
	
	/*
	 * function getMenus
	 * @param 
	 */
	
	public function getArticles()
	{
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');
		$limit 	= $this->getState('list.limit', 20);
		$start 	= $this->getState('list.start', 0);

		// Filter and Search
		$search = $this->getState('search') ;
		$layout = JRequest::getVar('layout') ;
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		
		// Search
		// ========================================================================
		if($search['index']){
			$q->where("a.title LIKE '%{$search['index']}%'");
		}
		
		
		$q->select("a.*,b.*, a.id AS id, a.title AS title, b.title AS cat_title, a.created AS created")
			->from("#__content AS a")
			->join("LEFT", "#__categories AS b ON a.catid = b.id")
			//->where("a.type = 'plugin'")
			->order( " {$order} {$dir}" ) ;
			;
		
		$db->setQuery($q);
		$result = $db->loadObjectList();
		
		$result = $result ? $result : array();
		
		foreach( $result as &$row ):
			$row->link = 'index.php?option=com_content&task=article.edit&id='.$row->id;
		endforeach;
		
		return $result ;
	}
}
