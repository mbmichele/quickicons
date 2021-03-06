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

class AkquickiconsController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Load the submenu.
		AkquickiconsHelper::addSubmenu(JRequest::getCmd('view', 'icons'));

		$view = JRequest::getCmd('view', 'icons');
        JRequest::setVar('view', $view);

		parent::display();
		$com = JComponentHelper::getComponent('com_akquickicons');
		
		if( AkquickiconsHelper::_('plugin.get', 'pro') ) {
			$version = 'Pro' ;
		}else{
			$version = 'Lite' ;
		}
		
		echo '<p align="center">Akquickicons Version: '.$version.'</p>';

		return $this;
	}
	
	
	/*
	 * function manager
	 * @param 
	 */
	
	public function manager()
	{
		include_once AKQUICKICONS_ADMIN.'/includes/elfinder/php/connector.php' ;
		jexit();
	}
}
