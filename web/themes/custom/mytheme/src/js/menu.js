(function($, Drupal, once) {
  Drupal.behaviors.burger_menu = {
    attach: function attach(context) {
      once("burger_menu", "body", context).forEach(function(element) {
        console.log("Good");
        $(".burger-button").click(function(e) {
          $(".burger-menu").toggleClass("active-menu");
        });
        $(".menu-close-button").click(function(e) {
          $(".burger-menu").toggleClass("active-menu");
        });
        $(".header-search-button").click(function(e) {
          $(".search").toggleClass("active-search-menu");
        });
        $(".search-close-button").click(function(e) {
          $(".search").toggleClass("active-search-menu");
        });
      });
    }
  };
  Drupal.behaviors.add_search = {
    attach(context, settings) {
      // eslint-disable-next-line camelcase
      const search_button = $('<div class="search-button"></div>');
      $(".header-search-button", context)
        .once("add_search")
        .append(search_button);
    }
  };
})(jQuery, Drupal, once);
