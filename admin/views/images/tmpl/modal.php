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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user	= JFactory::getUser();
$userId	= $user->get('id');

$function	= JRequest::getCmd('function', 'jSelectArticle');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_akquickicons');
$saveOrder	= $listOrder == 'a.ordering';

if( JVERSION >= 3 ) {
	JHtml::_('formbehavior.chosen', 'select');
}

?>

<form action="<?php echo $uri = JFactory::getURI()->toString() ; ?>" method="post" name="adminForm" id="adminForm">

	
	<?php
	
	$this->setLayout('default') ;
	echo $this->loadTemplate('filter') ;
	
	?>

	<table class="adminlist table table-striped">
		<thead>
			<tr>
				
				<th>
					<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JCATEGORY', 'b.title', $listDirn, $listOrder); ?>
				</th>
				
				<th width="5%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ACCESS', 'd.title', $listDirn, $listOrder); ?>
				</th>
				
				<th width="15%">
					<?php echo JHtml::_('grid.sort',  'JDATE', 'a.created', $listDirn, $listOrder); ?>
				</th>
				
				<th width="13%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_LANGUAGE', 'e.title', $listDirn, $listOrder); ?>
				</th>
				
                <th width="1%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			
			$item = new JObject($item);
			
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_akquickicons');
			$canEdit	= $user->authorise('core.edit',			'com_akquickicons');
			$canCheckin	= $user->authorise('core.manage',		'com_akquickicons');
			$canChange	= $user->authorise('core.edit.state',	'com_akquickicons');
			$canEditOwn = $user->authorise('core.edit.own',		'com_akquickicons');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				
				<td>
					<a class="pointer"
					   onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $item->a_id; ?>','<?php echo $this->escape(addslashes($item->a_title)); ?>');">
						<?php echo $this->escape($item->a_title); ?></a>
					<!--<p class="smallsub">
						<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape( $item->get('a_alias') ));?>
					</p>-->
				</td>
				
				<td class="center">
					<?php echo $item->get('b_title'); ?>
				</td>
				
				<td class="center">
					<?php echo $item->get('d_title'); ?>
				</td>
				
				<td class="center">
					<?php echo JHtml::_('date', $item->get('a_created'), JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				
				<td class="center">
					<?php if ($item->get('a_language')=='*'):?>
						<?php echo JText::alt('JALL', 'language'); ?>
					<?php else:?>
						<?php echo $item->get('e_title') ? $this->escape($item->e_title) : JText::_('JUNDEFINED'); ?>
					<?php endif;?>
				</td>

				<td class="center">
					<?php echo (int) $item->get('a_id'); ?>
				</td>
   
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>