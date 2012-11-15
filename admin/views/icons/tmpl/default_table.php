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



// Init some API objects
// ================================================================================
$app 	= JFactory::getApplication() ;
$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
$doc 	= JFactory::getDocument();
$uri 	= JFactory::getURI() ;
$user	= JFactory::getUser();
$userId	= $user->get('id');



// List Control
// ================================================================================
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_akquickicons');
$saveOrder	= $listOrder == 'a.ordering';
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
?>

<!-- List Table -->
<table class="table table-striped adminlist" id="articleList">
	<thead>
		<tr>
			<?php if( JVERSION >= 3 ): ?>
			<th width="1%" class="nowrap center hidden-phone">
				<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
			</th>
			<?php endif; ?>
			
			<th width="1%">
				<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
			</th>
			
			<th>
				<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
			</th>
			
			<th width="5%" class="nowrap">
				<?php echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
			</th>
			
			<?php if( JVERSION < 3 ): ?>
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
				<?php if ($canOrder && $saveOrder) :?>
					<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'icons.saveorder'); ?>
				<?php endif; ?>
			</th>
			<?php endif; ?>
			
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JCATEGORY', 'b.title', $listDirn, $listOrder); ?>
			</th>
			
			<th width="5%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ACCESS', 'd.title', $listDirn, $listOrder); ?>
			</th>
			
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JDATE', 'a.created', $listDirn, $listOrder); ?>
			</th>
			
			<th width="10%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_CREATED_BY', 'c.name', $listDirn, $listOrder); ?>
			</th>
			
			<th width="5%">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_LANGUAGE', 'e.title', $listDirn, $listOrder); ?>
			</th>
			
			<th width="1%" class="nowrap">
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>

		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="15">
				<div class="pull-left">
					<?php echo $this->pagination->getListFooter(); ?>
				</div>
				
				<?php if( JVERSION >= 3 ): ?>
				<!-- Limit Box -->
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<?php endif; ?>
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
		<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->a_catid?>">
		<?php if( JVERSION >= 3 ): ?>
			<!-- Drag sort for Joomla!3.0 -->
			<td class="order nowrap center hidden-phone">
			<?php if ($canChange) :
				$disableClassName = '';
				$disabledLabel	  = '';

				if (!$saveOrder) :
					$disabledLabel    = JText::_('JORDERINGDISABLED');
					$disableClassName = 'inactive tip-top';
				endif; ?>
				<span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
					<i class="icon-menu"></i>
				</span>
				<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->a_ordering;?>" class="width-20 text-area-order " />
			<?php else : ?>
				<span class="sortable-handler inactive" >
					<i class="icon-menu"></i>
				</span>
			<?php endif; ?>
			</td>
		<?php endif; ?>
		
			<td class="center">
				<?php echo JHtml::_('grid.id', $i, $item->a_id); ?>
			</td>
			
			<td class="nowrap has-context">
				<div class="pull-left">
				<?php if ($item->get('a_checked_out')) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->get('a_checked_out'), $item->get('a_checked_out_time'), 'icons.', $canCheckin); ?>
				<?php endif; ?>
				
				<?php if ($canEdit || $canEditOwn) : ?>
					<?php if( $item->images ): ?>
					<a href="<?php echo JRoute::_('index.php?option=com_akquickicons&task=icon.edit&id='.$item->a_id); ?>">
						<img src="<?php echo JURI::root().$item->images; ?>" width="32" alt="Thumb" style="float: left; margin-right: 10px;" />
					</a>
					<?php endif; ?>
					
					<a href="<?php echo JRoute::_('index.php?option=com_akquickicons&task=icon.edit&id='.$item->a_id); ?>">
						<?php if( JVERSION >= 3 ): ?>
						<i class="<?php echo $item->icon_class; ?>"></i>&nbsp;
						<?php endif; ?>
						<?php echo $item->get('a_title'); ?>
					</a>
				<?php else: ?>
					<?php if( $item->images ): ?>
					<img src="<?php echo JURI::root().$item->images; ?>" width="32" alt="Thumb" style="float: left; margin-right: 10px;" />
					<?php endif; ?>
					
					<?php if( JVERSION >= 3 ): ?>
						<i class="<?php echo $item->icon_class; ?>"></i>&nbsp;
					<?php endif; ?>
					<?php echo $item->get('a_title'); ?>
				<?php endif; ?>
				
				<?php if( JVERSION >= 3 ): ?>
				<div class="small">
					<?php echo $item->get('a_link');?>
				</div>
				<?php else: ?>
				<p class="smallsub">
					<?php echo $item->get('a_link');?>
				</p>
				<?php endif; ?>
				</div>
				
				
				<?php if( JVERSION >= 3 ): ?>
				<div class="pull-left">
					<?php
						// Create dropdown items
						JHtml::_('dropdown.edit', $item->id, 'icons.');
						JHtml::_('dropdown.divider');
						if ($item->a_published) :
							JHtml::_('dropdown.unpublish', 'cb' . $i, 'icons.');
						else :
							JHtml::_('dropdown.publish', 'cb' . $i, 'icons.');
						endif;
						
						JHtml::_('dropdown.divider');
						
						if ($item->a_checked_out) :
							JHtml::_('dropdown.checkin', 'cb' . $i, 'icons.');
						endif;
						
						
						if ($trashed) :
							JHtml::_('dropdown.untrash', 'cb' . $i, 'icons.');
						else :
							JHtml::_('dropdown.trash', 'cb' . $i, 'icons.');
						endif;
						
						
						// Render dropdown list
						echo JHtml::_('dropdown.render');
						?>
				</div>
				<?php endif; ?>
			</td>
			
			<td class="center">
				<?php echo JHtml::_('jgrid.published', $item->a_published, $i, 'icons.', $canChange, 'cb', $item->a_publish_up, $item->a_publish_down); ?>
			</td>
			
			<?php if( JVERSION < 3 ): ?>
			<td class="order">
				<?php if ($canChange) : ?>
					<?php if ($saveOrder) :?>
						<?php if ($listDirn == 'asc') : ?>
							<span><?php echo $this->pagination->orderUpIcon($i, true, 'icons.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
							<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'icons.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
						<?php elseif ($listDirn == 'desc') : ?>
							<span><?php echo $this->pagination->orderUpIcon($i, true, 'icons.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
							<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'icons.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
						<?php endif; ?>
					<?php endif; ?>
					<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $item->get('a_ordering');?>" <?php echo $disabled ?> class="text-area-order" />
				<?php else : ?>
					<?php echo $item->get('a_ordering'); ?>
				<?php endif; ?>
			</td>
			<?php endif; ?>
			
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
				<?php echo $item->get('c_name'); ?>
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