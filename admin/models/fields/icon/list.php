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

jimport('joomla.html.html');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldIcon_list extends JFormFieldItemlist
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'Icon_list';
	
	public $value ;
	
	public $name ;
	
	
	protected $view_list = 'icons' ;
	
	protected $view_item = 'icon' ;
	
	protected $extension = 'com_akquickicons' ;
}