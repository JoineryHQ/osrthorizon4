<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if (JFactory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- osrthorizon/html/./com_content/category/custom.php -->';}

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

/* echo '<pre>';
  var_dump($this->intro_items[0]->jcfields[3]->rawvalue); */

?>
<div class="blog blog<?php echo $this->pageclass_sfx; ?> content-category-custom">
  <div class="page-header">
<?php if ($this->params->get('show_page_heading')) : ?>
      <div class="page-header scrollspy" spy-title="<?php echo $this->escape($this->params->get('page_heading')); ?>">
        <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
      </div>
<?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
      <h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
      <?php if ($this->params->get('show_category_title')) : ?>
          <span class="subheading-category scrollspy" spy-title="<?php echo $this->category->title; ?>">
          <?php echo $this->category->title; ?>
          </span>
          <?php endif; ?>
      </h2>
      <?php endif; ?>
    <div class="page-header-image">
    <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
        <?php if (!empty($this->intro_items[0]->jcfields[3]->rawvalue)) : ?>
          <!-- Image specified in Article field "Article image (thumbnail)" for the top-most article in the section. -->
          <img class="category-thumbnail" src="<?php echo $this->intro_items[0]->jcfields[3]->rawvalue; ?>"/>
        <?php endif; ?>
        <img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
      <?php endif; ?>
    </div>
  </div>

  <div class="blog<?php echo $this->pageclass_sfx; ?>-content main-content container clearfix" itemscope itemtype="https://schema.org/Blog">
    <div class="main-content__left">
      <?php if (
        ($this->params->get('show_description', 1) && $this->category->description)
      ) : ?>
        <div class="category-desc clearfix">
          <?php if ($this->params->get('show_description') && $this->category->description) : ?>
            <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>

      <?php
      $counter = 0;
      ?>
      <?php if (!empty($this->intro_items)) : ?>
        <?php foreach ($this->intro_items as $key => &$item) : ?>
          <?php $rowcount = ((int) $key + 1); ?>
            <div class="items-row cols-1 <?php echo 'row-' . $counter; ?> row items-row-alias-<?php echo $item->alias ?> clearfix scrollspy" spy-title="<?php echo $item->title; ?>">
            <div class="col-12">
              <div class="item osrthorizon-row-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
                   itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                <?php
                $this->item = &$item;
                echo $this->loadTemplate('item');
                ?>
              </div><!-- end item -->
              <?php $counter++; ?>
            </div><!-- end span -->
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
      <!-- position-10 START --><?php echo $this->document->getBuffer('modules', 'position-10', array('style' => 'html5')); ?><!-- position-10 END -->
    </div>
    <div class="main-content__right">
      <div id="indicator" class="block-stiky"></div>
    </div>
  </div>
</div>
<!-- END: osrthorizon/html/./com_content/category/custom.php -->
