<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_list
 * @Author		web-eau.net
 * @copyright   Copyright (C) 2012 - 2019 - web-eau.net - All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Contact\Site\Helper\RouteHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$isBootstrap = ($params->get('layout_style') === 'bslayout');
?>
<div class="mod-contacts-list<?php echo htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8'); ?>">
    <?php if ($isBootstrap): ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php else: 
      $a = 1;
      ?>
    <ul class="contact-list list-unstyled">
    <?php endif; ?>

    <?php foreach ($list as $contact): ?>
        <?php
        $slug = $contact->id . ':' . $contact->alias;
        $link = Route::_(RouteHelper::getContactRoute($slug, $contact->catid));
        $imageUrl = !empty($contact->image) ? $contact->image : '';
        $showImage = $params->get('show_image');
        $imgStyle = $params->get('image_style', 'img-circle');
        $imgWidth = (int) $params->get('image_width', 100);
        ?>
        <?php if ($isBootstrap): ?>
        <div class="col">
            <div class="card h-100 text-center">
                <?php if ($showImage && $imageUrl): ?>
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                             alt="<?php echo htmlspecialchars($contact->name, ENT_QUOTES, 'UTF-8'); ?>"
                             class="card-img-top <?php echo $imgStyle; ?>"
                             style="width: <?php echo $imgWidth; ?>px; height: auto;">
                    </a>
                <?php endif; ?>
                <div class="card-body">
                    <a href="<?php echo $link; ?>">
                        <h5 class="card-title"><?php echo htmlspecialchars($contact->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                    </a>
                    <?php if ($params->get('show_position') && !empty($contact->con_position)): ?>
                        <p class="card-text"><small><?php echo htmlspecialchars($contact->con_position, ENT_QUOTES, 'UTF-8'); ?></small></p>
                    <?php endif; ?>
                    <?php if ($params->get('show_email') && !empty($contact->email_to)): ?>
                        <a href="mailto:<?php echo $contact->email_to; ?>"
                           class="btn btn-outline-primary mt-2"
                           aria-label="<?php echo Text::_('MOD_CONTACTS_LIST_EMAIL_ARIA_LABEL') . ' ' . htmlspecialchars($contact->name, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo Text::_('MOD_CONTACTS_LIST_SEND_EMAIL'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <li class="d-flex align-items-start mb-3">
            <?php if ($showImage && $imageUrl): ?>
                <div class="contact-img me-3">
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                             alt="<?php echo htmlspecialchars($contact->name, ENT_QUOTES, 'UTF-8'); ?>"
                             class="<?php echo $imgStyle; ?>"
                             style="width: <?php echo $imgWidth; ?>px; height: auto;">
                    </a>
                </div>
            <?php endif; ?>
            <div>
                <a href="<?php echo $link; ?>">
                    <h4><?php echo htmlspecialchars($contact->name, ENT_QUOTES, 'UTF-8'); ?></h4>
                </a>
                <?php if ($params->get('show_position') && !empty($contact->con_position)): ?>
                    <p><?php echo htmlspecialchars($contact->con_position, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>
                <?php if ($params->get('show_email') && !empty($contact->email_to)): ?>
                    <p><a href="mailto:<?php echo $contact->email_to; ?>"><?php echo htmlspecialchars($contact->email_to, ENT_QUOTES, 'UTF-8'); ?></a></p>
                <?php endif; ?>

                <!-- Show Phone, unconditionally -->
                <?php if(!empty($contact->telephone)) :?>
                <p class="mod_contact_list-contact-telephone"><?php echo $contact->telephone; ?></p>
                <?php endif; ?>
                    
            </div>
        </li>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($isBootstrap): ?>
    </div>
    <?php else: ?>
    </ul>
    <?php endif; ?>
</div>