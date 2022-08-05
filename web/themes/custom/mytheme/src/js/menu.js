(function($, Drupal, once) {
  Drupal.behaviors.burger_menu = {
    attach: function attach(context) {
      once("burger_menu", "body", context).forEach(function() {
        $(".burger-button").click(function() {
          $(".burger-menu").toggleClass("active-menu");
        });
        $(".menu-close-button").click(function() {
          $(".burger-menu").toggleClass("active-menu");
        });
        $(".header-search-button").click(function() {
          $(".search").toggleClass("active-search-menu");
        });
        $(".search-close-button").click(function() {
          $(".search").toggleClass("active-search-menu");
        });
      });
    }
  };
  Drupal.behaviors.add_search = {
    attach(context) {
      const searchButton = $('<div class="search-button"></div>');
      $(".header-search-button", context)
        .once("add_search")
        .append(searchButton);
    }
  };
  Drupal.behaviors.news_slider = {
    attach: function attach(context) {
      const $buttonPrevious = $(
        `<div<div class="previous-button"><span>←</span></div></div>`
      );
      const $buttonNext = $(
        '<div<div class="next-button"><span>→</span></div></div>'
      );
      $(".pager-news-slider .view-content", context)
        .once("news_slider")
        .each(function() {
          $(".pager-news-slider")
            .prepend($buttonNext)
            .prepend($buttonPrevious);
          $buttonPrevious.click(function() {
            $(".pager-news-slider .pager .pager__item--previous>a").trigger(
              "click"
            );
          });
          $buttonNext.click(function() {
            $(".pager-news-slider .pager .pager__item--next>a").trigger(
              "click"
            );
          });
        });
    }
  };
})(jQuery, Drupal, once);
