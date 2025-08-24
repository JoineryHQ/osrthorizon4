<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.JoomStarter
 *
 * @copyright   (C) YEAR Your Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * This is a heavily stripped down/modified version of the default Cassiopeia template, designed to build new templates off of.
 */

defined('_JEXEC') or die;  //required for basically ALL php files in Joomla, for security. Prevents direct access to this file by url.

//Imports ("use" statements) - objects from Joomla that we want to use in this file
use Joomla\CMS\Factory; // Factory class: Contains static methods to get global objects from the Joomla framework. Very important!
use Joomla\CMS\HTML\HTMLHelper; // HTMLHelper class: Contains static methods to generate HTML tags.
use Joomla\CMS\Language\Text; // Text class: Contains static methods to get text from language files
use Joomla\CMS\Uri\Uri; // Uri class: Contains static methods to manipulate URIs.

/** @var Joomla\CMS\Document\HtmlDocument $this */

if (Factory::getApplication()->get('osrthorizon_enable_info_comments')) {echo '<!-- osrthorizon/index.php -->';}

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();  // Get the Web Asset Manager - used to load our CSS and JS files

// Add Favicon from images folder
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/x-icon']);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

/* ******** joomstarter: testparam START
//Get params from template styling
//If you want to add your own parameters you may do so in templateDetails.xml
$testparam =  $this->params->get('testparam');
//uncomment to see how this works on site... it just shows 1 or 0 depending on option selected in style config.
//You can use this style to get/set any param according to instructions at https://kevinsguides.com/guides/webdev/joomla4/joomla-4-templates/adding-config
//echo('the value of testparam is: '.$testparam);

// Get this template's path
$templatePath = 'templates/' . $this->template;
******** joomstarter: testparam END */


//load bootstrap collapse js (required for mobile menu to work)
//this loads collapse.min.js from media/vendor/bootstrap/js - you can check out that folder to see what other bootstrap js files are available if you need them
HTMLHelper::_('bootstrap.collapse');
//dropdown needed for 2nd level menu items
HTMLHelper::_('bootstrap.dropdown');
//You could also load all of bootstrap js with this line, but it's not recommended because it's a lot of extra code that you probably don't need
//HTMLHelper::_('bootstrap.framework');


//Register our web assets (Css/JS) with the Web Asset Manager
//The files are defined in joomla.asset.json!!! If you don't want to use the included CSS or JS, just remove these lines or replace the CSS/JS files with your own code!
$wa->useStyle('template.osrthorizon.template.css');
$wa->useStyle('template.osrthorizon.user.css');
$wa->useScript('template.osrthorizon.template.js');

/* ******** fixme: osrthorizon: additional js and css files START
JHtml::_('script', 'scrollspy.min.js', array('version' => 'auto', 'relative' => true));
// Include our own copy of swiper.js for ad banner sliders
JHtml::_('script', 'swiperswiper-bundle.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'custom.js', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'style.css', array('version' => 'auto', 'relative' => true));
******** fixme: osrthorizon: additional js and css files END */

/* ******** fixme: osrthorizon: adjust witdh based on position content START
// Adjusting content width
$position7ModuleCount = $this->countModules('position-7');
$position8ModuleCount = $this->countModules('position-8');
$position9ModuleCount = $this->countModules('position-9');
$position11ModuleCount = $this->countModules('position-11');

if ($position7ModuleCount && $position8ModuleCount)
{
	$span = 'span6';
}
elseif ($position7ModuleCount && !$position8ModuleCount)
{
	$span = 'span9';
}
elseif (!$position7ModuleCount && $position8ModuleCount)
{
	$span = 'span9';
}
else
{
	$span = 'span12';
}
******** fixme: osrthorizon: adjust witdh based on position content END */

/* ******** fixme: osrthorizon: logo file START
// Logo file or site title param
$logo = '<img src="' . htmlspecialchars(JUri::root() . 'templates/osrthorizon/images/logo-header.png', ENT_QUOTES) . '" alt="' . $sitename . '" />';
******** fixme: osrthorizon: logo file END */


//Set viewport meta tag for mobile responsiveness -- very important for scaling on mobile devices
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>

<?php // Everything below here is the actual "template" part of the template. Where we put our HTML code for the layout and such. ?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<!-- Google tag (gtag.js) -->
<script async src=https://www.googletagmanager.com/gtag/js?id=G-JBQHYMD224></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-JBQHYMD224');
 </script> 

    <?php // Loads important metadata like the page title and viewport scaling ?>
	<jdoc:include type="metas" />

    <?php // Loads the site's CSS and JS files from web asset manager ?>
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />

    <?php /** joomstarter comment: 
     * You can put links to CSS/JS just like any regular HTML page here too, and remove the jdoc:include script/style lines above if you want.
     * Do not delete the metas line though
     * 
     * For example, if you want to manually link to a custom stylesheet or script, you can do it like this:
     * <link rel="stylesheet" href="https://mysite.com/templates/mytemplate/mycss.css" type="text/css" />
     * <script src="https://mysite.com/templates/mytemplate/myscript.js"></script>
     * */ 
    ?>
    
</head>

<?php // you can change data-bs-theme to dark for dark mode  // ?>
<body class="site <?php echo $pageclass; ?> <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : ' no-item')
	// . ($params->get('fluidContainer') ? ' fluid' : '')
  ;
?>" data-bs-theme="light">
  <header class="header">
    <div class="header__left">
				<div class="header-inner clearfix">
					<a class="brand pull-left" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
						<?php if ($this->params->get('sitedescription')) : ?>
							<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription'), ENT_COMPAT, 'UTF-8') . '</div>'; ?>
						<?php endif; ?>
					</a>
				</div>
    </div>      
    <div class="header__right-bottom">
        <div class="header-search pull-right">
            <!-- position-0 START --><jdoc:include type="modules" name="position-0" style="none" /><!-- position-0 END -->
        </div>
        <img class="header-img" src="/templates/osrthorizon/images/header-line.png" alt="">
    </div>      
    
    <?php
    /* ******************** joomstarter: top-bar START
        <?php // Generate a Bootstrap Navbar for the top of our website and put the site title on it ?>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            <div class="container">
                <a href="" class="navbar-brand"><?php echo ($sitename); ?></a>
                <?php // Update 1.14 - Added support for mobile menu with bootstrap ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <?php // Put menu links in the navbar - main menu must be in the "menu" position!!! Only supports top level and 1 down, so no more than 1 level of child items ?>
                <?php if ($this->countModules('menu')): ?>
                <div class="collapse navbar-collapse" id="mainmenu"><jdoc:include type="modules" name="menu" style="none" /></div>

                <?php endif; ?>
            </div>
        </nav>
        <?php // Load Header Module if Module Exists ?>
        <?php if ($this->countModules('header')) : ?>
            <div class="headerClasses">
                <jdoc:include type="modules" name="header" style="none" />
            </div>
        <?php endif; ?>
    ******************** joomstarter: top-bar END */ ?>
  </header>
  <?php if ($this->countModules('position-1')) : ?>
    <nav class="navigation" role="navigation">
        <div class="navigation-block">
            <!-- position-1 START --><jdoc:include type="modules" name="position-1" style="none" /><!-- position-1 END -->
            <?php if ($position11ModuleCount) : ?>
              <div class="menu-optional-wrapper">
                <div class="menu-optional">
                    <!-- position-11 START --><jdoc:include type="modules" name="position-11" style="none" /><!-- position-11 END -->
                </div>
              </div>
            <?php endif; ?>
        </div>
    </nav>
  <?php endif; ?>
  <!-- position-3 START --><jdoc:include type="modules" name="position-3" style="none" /><!-- position-3 END -->
  <!-- position-4 START --><jdoc:include type="modules" name="position-4" style="xhtml" /><!-- position-4 END -->
  <!-- position-5 START --><jdoc:include type="modules" name="position-5" style="xhtml" /><!-- position-5 END -->
  <!-- position-7 START --><jdoc:include type="modules" name="position-7" style="well" /><!-- position-7 END -->
  
    <?php // Generate the main content area of the website ?>
    <div class="siteBody">
        <div class="container">
            <div class="row">
              <main>
                <!-- message START -->
                  <jdoc:include type="message" />
                <!-- message END -->
                <!-- component START -->
                  <jdoc:include type="component" />
                <!-- component END -->
              </main>
            </div>
        </div>
    </div>
  
  
    <div class="clearfix"></div>
    <!-- position-9 START --><jdoc:include type="modules" name="position-9" style="none" /><!-- position-9 END -->
    <div class="clearfix"></div>

    <?php // Load Footer ?>
    <footer class="footer mt-auto py-3 bg-light ">
        <div class="wrapper">
            <div class="footer-block">
                <img src="/templates/osrthorizon/images/footer-line.png" alt="">
            </div>
            <div class="footer-main">
                <?php echo $logo; ?>
              <!-- footer: START -->
                <jdoc:include type="modules" name="footer" style="none" />
              <!-- footer: END -->
            </div>
            <div class="footer-bottom">
              <!-- footer-2: START -->
			    <jdoc:include type="modules" name="footer-2" style="none" />
              <!-- footer-2: END -->
            </div>
        </div>
    </footer>

    <?php // Include any debugging info ?>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
