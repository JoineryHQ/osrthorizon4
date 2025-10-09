/*
 * ScrollSpy to create and monitor sidebar on-page TOC
 *
 * This script assumes jQuery as $, and makes only minimum tests to confirm that.
 */
"use strict";

class ScrollSpy {
  /**
   * Scroll delay in miliseconds, for efficient auto-calculation of active target
   * upon scroll; prevents needless churn by waiting a few miliseconds before calulcating.
   */
  delay = 200;

  /**
   * Height in pixels of an arbitrary region extending from the top of the viewpoort.
   * If a target is placed at or above this region (e.g. after scrolling), it's
   * considered to have been active.
   * @type Number
   */
  activeTopMax = 200;

  /**
   * jQuery selector to identify page elements which should be represented among
   * scrollspy indictors
   * @type string
   */
  sectionSelector;

  /**
   * jQuery selector indicating the container into which the scrollspy menu should be placed.
   * @type string
   */
  containerSelector;

  /**
   * jQuery element for container (as specified by this.containerSelector)
   * @type jQuery element
   */
  container;

  /**
   * Array of page DOM elements represented among scrollspy indicators.
   * Note these are stored in reverse order (bottom-of-page-first), because for
   * on-scroll auto-calculation of the "current" item, we'll loop through them
   * starting from the bottom.
   * @type Array
   */
  sectionTargets = [];

  /**
   * Array of auto-generated jQuery elements representing scrollspy menu items.
   * @type Array
   */
  indicators = [];

  constructor(settings) {
    if (!$) {
      // No jquery? Can't help you.
      return;
    }

    // Set object properties based on passed settings object values.
    if (typeof settings['delay'] != 'undefined') {
      this.delay = 1 * settings['delay'];
    }
    if (typeof settings['sectionSelector'] != 'undefined') {
      this.sectionSelector = '' + settings['sectionSelector'];
    }
    if (typeof settings['containerSelector'] != 'undefined') {
      this.containerSelector = '' + settings['containerSelector'];
    }

    this.container = $(this.containerSelector);
    if (!this.container.length) {
      // This page has no container; no place to show scrollspy links; nothing to do.
      return;
    }

    this.initialize();
    this.setActiveIndicator();
  }

  initialize() {
    var containerUl = $('<ul class="scrollspy-indicator-container">').appendTo(this.container);
    var sectionTargets = [];
    var indicators = [];
    var scrollspy = this;

    // For each on-page section-to-be-referenced...
    $(this.sectionSelector).each(function(idx, el){
      // Define an object of attributes to store for each section.
      var targetAttributes = {};
      // Note the appropriately classed named anchor within the section, if any.
      var anchor = $(el).find('a.section-header-link');

      if (anchor.length) {
        // If there is such an anchor, this is a true section.
        targetAttributes = {
          anchor: anchor[0],
          handle: $(anchor).attr('name'),
        }
      }
      else {
        // If there's no such anchor, this is the top-of-page header.
        targetAttributes = {
          anchor: $('body')[0],
          handle: 'scrollspy-default',
        }
      }
      // Create a clickable indicator item in the scrollspy menu, and store it for future acces.
      var indicator = $('<li class="spy-clickable spy-handle-' + targetAttributes.handle + '">' + $(el).attr('spy-title') + '</li>').appendTo(containerUl);
      indicator.on('click', targetAttributes, scrollspy.scrollToIndicator);
      indicators.push(indicator);
      sectionTargets.push(targetAttributes);
    });
    // Store sectionTargets in reverse order (bottom-of-page-first).
    this.sectionTargets = sectionTargets.reverse();
    this.indicators = indicators;

    $(window).on('scroll', {scrollspy: this}, this.onScroll);

  }

  /**
   * Scroll the page to a given on-page DOM element, represented by e.data.anchor.
   * @param event e
   * @returns void
   */
  scrollToIndicator(e) {
    if (e.data && e.data.anchor) {
      e.data.anchor.scrollIntoView({
        behavior: 'smooth'
      });
    }
  }

  /**
   * For the given target, update the browser url to point to the relevant #anchor.
   * @param object target
   * @returns void
   */
  replaceHistoryAnchor(target) {
    var url = ''
    if (target.handle && target.handle != 'scrollspy-default') {
      // This is a real on-page section, so we'll specify an appropriate url #anchor.
      url = "#" + target.handle;
    }
    else {
      // This is the (default item) top-of-page header. Strip the #anchor from the URL.
      url = location.href.split('#')[0];
    }
    window.history.replaceState("", "", url);
  };

  /**
   * Based on the current page scroll position, set one of the scrollspy menu
   * items as active.
   * @returns void
   */
  setActiveIndicator() {
    // Page scroll vertical position.
    var windowScrollTop = $(window).scrollTop();

    var activeTarget = null;

    // Loop through all section targets (which are ordered bottom-of-page-first).
    // As soon as we find one that's within the top-of-page region bounded by
    // this.activeTopMax, count that one as active and quit the loop.
    for (var i in this.sectionTargets) {
      var target = this.sectionTargets[i];
      var targetScrollTop = $(target.anchor).offset().top - windowScrollTop;
      if (targetScrollTop <= this.activeTopMax) {
        activeTarget = target;
        break;
      }
    }

    // Update status of all indicators, by removing the 'spy-active' class
    // and then re-adding it only if it has a class showing that it's the indicator
    // for the active item.
    for (i in this.indicators) {
      var indicator = this.indicators[i];
      if (indicator.hasClass('spy-handle-'+ activeTarget.handle)) {
        indicator.addClass('spy-active');
      }
      else {
        indicator.removeClass('spy-active');
      }
    }
    // Update the page url.
    this.replaceHistoryAnchor(target);
  }

  /**
   * Process a scroll event (i.e., we assume here that we've waited `this.delay`
   * milliseconds within the current onScroll event)
   */
  processScroll() {
    this.setActiveIndicator();
    this.lastScrollFireTime = new Date().getTime();
  }

  /**
   * onScroll event handler.
   * @param event e
   */
  onScroll(e) {
    var scrollspy = e.data.scrollspy;
    let now = new Date().getTime();

    if (!scrollspy.scrollTimer) {
      // fire immediately once.
      scrollspy.processScroll();
      // process once again, only after delay.
      scrollspy.scrollTimer = setTimeout((scrollspy) => {
        scrollspy.scrollTimer = null;
        scrollspy.processScroll();
      }, scrollspy.delay, scrollspy);
    }
  }
}
