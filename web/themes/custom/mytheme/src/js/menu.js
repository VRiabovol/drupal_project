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
})(jQuery, Drupal, once);
