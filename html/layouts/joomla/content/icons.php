<?php
/**
 * osrthorizon - j4 - unused in j3?
 * osrthorizon override for layouts/joomla/content/icons.php
 */

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

if (Factory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- START: osrthorizon/html/./layouts/joomla/content/icons.php -->';}

$canEdit   = $displayData['params']->get('access-edit');
$articleId = $displayData['item']->id;
?>

<?php if ($canEdit) : ?>
    <div class="icons osrthorizon-hide-icons">
        <div class="float-end">
            <div>
                <?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?>
            </div>
        </div>
    </div>
<?php endif;

if (Factory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- END: osrthorizon/html/./layouts/joomla/content/icons.php -->';}
