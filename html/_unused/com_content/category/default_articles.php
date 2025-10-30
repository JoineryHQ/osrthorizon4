<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- START: osrthorizon/html/./com_content/category/default_articles.php -->';}

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Language\Multilanguage;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Create some shortcuts.
$n          = count($this->items);
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$langFilter = false;

// Tags filtering based on language filter
if (($this->params->get('filter_field') === 'tag') && (Multilanguage::isEnabled()))
{
	$tagfilter = ComponentHelper::getParams('com_tags')->get('tag_list_language_filter');

	switch ($tagfilter)
	{
		case 'current_language' :
			$langFilter = JFactory::getApplication()->getLanguage()->getTag();
			break;

		case 'all' :
			$langFilter = false;
			break;

		default :
			$langFilter = $tagfilter;
	}
}

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}

// For B/C we also add the css classes inline. This will be removed in 4.0.
JFactory::getDocument()->addStyleDeclaration('
.hide { display: none; }
.table-noheader { border-collapse: collapse; }
.table-noheader thead { display: none; }
');

$tableClass = $this->params->get('show_headings') != 1 ? ' table-noheader' : '';

$nullDate    = JFactory::getDbo()->getNullDate();
$currentDate = JFactory::getDate()->format('Y-m-d H:i:s');

?>
<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
<?php if ($this->params->get('filter_field') !== 'hide' || $this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters btn-toolbar clearfix">
		<legend class="hide"><?php echo JText::_('COM_CONTENT_FORM_FILTER_LEGEND'); ?></legend>
		<?php if ($this->params->get('filter_field') !== 'hide') : ?>
			<div class="btn-group">
				<?php if ($this->params->get('filter_field') === 'tag') : ?>
					<select name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();">
						<option value=""><?php echo JText::_('JOPTION_SELECT_TAG'); ?></option>
						<?php echo JHtml::_('select.options', JHtml::_('tag.options', array('filter.published' => array(1), 'filter.language' => $langFilter), true), 'value', 'text', $this->state->get('filter.tag')); ?>
					</select>
				<?php elseif ($this->params->get('filter_field') === 'month') : ?>
					<select name="filter-search" id="filter-search" onchange="document.adminForm.submit();">
						<option value=""><?php echo JText::_('JOPTION_SELECT_MONTH'); ?></option>
						<?php echo JHtml::_('select.options', JHtml::_('content.months', $this->state), 'value', 'text', $this->state->get('list.filter')); ?>
					</select>
				<?php else : ?>
					<label class="filter-search-lbl element-invisible" for="filter-search">
						<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;'; ?>
					</label>
					<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" />
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="btn-group pull-right">
				<label for="limit" class="element-invisible">
					<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />
	</fieldset>

	<div class="control-group hide pull-right">
		<div class="controls">
			<button type="submit" name="filter_submit" class="btn btn-primary"><?php echo JText::_('COM_CONTENT_FORM_FILTER_SUBMIT'); ?></button>
		</div>
	</div>

<?php endif; ?>

<?php if (empty($this->items)) : ?>
	<?php if ($this->params->get('show_no_articles', 1)) : ?>
		<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>
<?php else : ?>

<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
	<?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
		<div class="pagination">

			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>

			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
</form>
<?php if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- END: osrthorizon/html/./com_content/category/custom.php -->';}
