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

<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
      <?php endif; ?>

      <?php if (
        ($this->params->get('show_description', 1) && $this->category->description)
      ) : ?>
        <div class="category-desc clearfix">
          <?php if ($this->params->get('show_description') && $this->category->description) : ?>
            <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>

      <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
        <?php if ($this->params->get('show_no_articles', 1)) : ?>
          <p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
        <?php endif; ?>
      <?php endif; ?>

      <?php $leadingcount = 0; ?>
      <?php if (!empty($this->lead_items)) : ?>
        <div class="items-leading clearfix">
        <?php foreach ($this->lead_items as &$item) : ?>
            <div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
                 itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
    <?php
    $this->item = &$item;
    echo $this->loadTemplate('item');
    ?>
            </div>
                   <?php $leadingcount++; ?>
          <?php endforeach; ?>
        </div><!-- end items-leading -->
        <?php endif; ?>

      <?php
      $introcount = count($this->intro_items);
      $counter = 0;
      ?>

      <?php if (!empty($this->intro_items)) : ?>
        <?php foreach ($this->intro_items as $key => &$item) : ?>
          <?php $rowcount = ((int) $key + 1); ?>
          <?php if ($rowcount === 1) : ?>
            <?php $row = $counter; ?>
            <div class="items-row cols-1 <?php echo 'row-' . $row; ?> row items-row-alias-<?php echo $item->alias ?> clearfix scrollspy" spy-title="<?php echo $item->title; ?>">
          <?php endif; ?>
            <div class="col-12">
              <div class="item osrthorizon-row-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
                   itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
    <?php
    $this->item = &$item;
    echo $this->loadTemplate('item');
    ?>
              </div>
              <!-- end item -->
    <?php $counter++; ?>
            </div><!-- end span -->
              <?php if (($rowcount == 1) or ($counter == $introcount)) : ?>
            </div><!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if (!empty($this->link_items)) : ?>
        <div class="items-more">
        <?php echo $this->loadTemplate('links'); ?>
        </div>
        <?php endif; ?>

      <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
        <div class="cat-children">
        <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
            <h3> <?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
          <?php endif; ?>
          <?php echo $this->loadTemplate('children'); ?> </div>
        <?php endif; ?>
        <!-- position-10 START --><?php echo $this->document->getBuffer('modules', 'position-10', array('style' => 'none')); ?><!-- position-10 END -->
    </div>
    <div class="main-content__right">
      <div id="indicator" class="block-stiky block-stiky__advocacy"></div>
    </div>
  </div>
</div>
<!-- END: osrthorizon/html/./com_content/category/custom.php -->
