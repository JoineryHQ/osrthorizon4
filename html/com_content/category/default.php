<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- osrthorizon/html/./com_content/category/default.php -->';}

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

?>
<div class="category-list<?php echo $this->pageclass_sfx; ?>">

<?php
$this->subtemplatename = 'articles';
echo JLayoutHelper::render('joomla.content.category_default', $this);
?>

</div>
