(function (jQuery) {
  jQuery.fn.toggleHeaderOnScroll = function () {
    var $header = this;

    jQuery(window).on('scroll', function () {
      if (jQuery(this).scrollTop() > 0) {
        $header.addClass('scrolled');
      } else {
        $header.removeClass('scrolled');
      }
    });

    return this;
  };
})(jQuery);