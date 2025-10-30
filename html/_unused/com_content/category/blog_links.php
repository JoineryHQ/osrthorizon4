<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- START: osrthorizon/html/./com_content/category/blog_links.php -->';}
?>

<ol class="nav nav-tabs nav-stacked">
	<?php foreach ($this->link_items as &$item) : ?>
		<li>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>">
				<?php echo $item->title; ?></a>
		</li>
	<?php endforeach; ?>
</ol>
<?php if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- END: osrthorizon/html/./com_content/category/blog_links.php -->';}
