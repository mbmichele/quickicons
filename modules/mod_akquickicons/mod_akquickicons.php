<?php
/**
 * @package		Asikart Joomla! Extansion Example
 * @subpackage	mod_example
 * @copyright	Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$buttons = modAkquickiconsHelper::getList($params) ;
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if( JVERSION >= 3 ){
	require JModuleHelper::getLayoutPath('mod_akquickicons', $params->get('layout', 'joomla25'));
}else{
	require JModuleHelper::getLayoutPath('mod_akquickicons', 'joomla25');
}