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
      // const $bu = once("news_slider", ".pager-news-slider", context);
      const $buttonPrevious = $(
        '<div class="previous-button">\n' +
          "                  <span>←</span>\n" +
          "                </div>"
      );
      const $buttonNext = $(
        '<div class="next-button">\n' +
          "                  <span>→</span>\n" +
          "                </div>"
      );
      once("news_slider", ".pager-news-slider", context).forEach(function() {
        $(".view-content", ".pager-news-slider")
          .prepend($buttonPrevious)
          .append($buttonNext);
        $(".previous-button", ".pager-news-slider").click(function() {
          const previous = $("a[rel~='prev']", ".pager-news-slider");
          previous[0].click();
        });
        $(".next-button").click(function() {
          const next = $("a[rel~='next']", ".pager-news-slider");
          next[0].click();
        });
      });
    }
  };
})(jQuery, Drupal, once);
