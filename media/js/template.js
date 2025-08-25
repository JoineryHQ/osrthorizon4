(function ($) {

  $(document).ready(function () {
    /* "Back to top" */
    $(".main-content__top").click(function () {
      $('html, body').animate({scrollTop: 0}, 300);
      return false;
    });

    /* Hamburger menu */
    $('.burger').on('click', function () {
      $(this).toggleClass('active');
      $('body').toggleClass('hamburger-active');
    })

    /* OSRTHORIZON-FIXME: TRANSLATE: Фиксирование плашки  */
    $(window).scroll(function () {
      if ($(this).scrollTop() === $('.banner').height() || $(this).scrollTop() > $('.banner').height()) {
        $('.block-stiky').addClass("fixed");
      } else {
        $('.block-stiky').removeClass("fixed");
      }
    });

    /**
     * Given a string (expected: the spy-title attribute of a scrollSpy TOC item),
     * normalize that in a way that can be used for the named-anchor part of
     * a URL.
     * This should work EXACTLY the same as the PHP method OsrthorizonUtils::normalizeSectionHeaderLink().
     */
    var normalizeSpyTitle = function normalizeSpyTitle(str) {
      if (typeof str == 'string') {
        return str.trim().replace(/[^0-9a-zA-Z]/g, '-').toLowerCase();
      }
    }
    /**
     * callbackOnChange handler for scrollspy. For the given scrollspy element,
     * update the browser url to point to the relevant #anchor.
     * @param {type} el
     * @returns {undefined}
     */
    var replaceHistoryAnchor = function replaceHistoryAnchor(el) {
      var spyTitle = $(el).attr('spy-title');
      var normalizedSpyTitle = normalizeSpyTitle(spyTitle);
      window.history.replaceState("", "", "#" + normalizedSpyTitle);
    };

    /* Auto-generated TOC (https://www.cssscript.com/update-navigation-scroll-position-scrollspy/) */
    let spy = new ScrollSpy({
      contexts_class: 'scrollspy',
      callbackOnChange: replaceHistoryAnchor
    });
    let indicator = document.getElementById('indicator');

    if (indicator) {
      spy.Indicator({
        element: indicator,
      });
    }

    // Add 'swiper' class to div.bannergroup
    $('div.bannergroup').addClass('swiper');
    //  create a swiper-wrapper div inside of div.bannergroup.
    $('div.bannergroup').append('<div class="swiper-wrapper">');
    // Move all div.banneritem elements into div.swipper-wrapper
    $('div.bannergroup div.banneritem').appendTo('div.swiper-wrapper');
    $('div.bannergroup div.swiper-wrapper div.banneritem').addClass('swiper-slide');
    // Define options and initialize swiper.
    var mainSliderOptions = {
      slidesPerView: 2,
      spaceBetween: 15,
      effect: '',
      speed: 1000,
      loop: true,
      navigation: false,
      autoplay: {
        delay: 15000,
      },
      breakpoints: {
        577: {
          slidesPerView: 3,
          spaceBetween: 30
        },
      }
    };
    var swiper = new Swiper(".bannergroup.swiper", mainSliderOptions);

    var tab = $('.custom-tabs');
    if (tab != undefined) {

      $('.custom-tabs table').addClass('hidden');
      var customTabsStartingHeight = $('.custom-tabs').height() + 110;

      tab.find('h4').on('click', function (e) {
        $('.custom-tabs table').addClass('hidden');
        $('.custom-tabs h4').removeClass('active');
        $(this).addClass('active');
        $(this).next('table').removeClass('hidden');

        var tableHeight = $('.custom-tabs table').not('.hidden').height();
        if (tableHeight > customTabsStartingHeight) {
          $('.custom-tabs').css({'height': (tableHeight + 70), 'margin': 30});
        } else {
          $('.custom-tabs').css({'height': customTabsStartingHeight});
        }
      });
      tab.find('h4').first().click();
    }
  });
})(jQuery);
