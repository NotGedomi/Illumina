(function(jQuery) {
    jQuery.fn.agreementsAccordion = function() {
        const $containers = this.find('.container');
        
        $containers.on('click', function() {
            const $this = jQuery(this);
            const $next = $this.next('.container');
            
            if ($this.hasClass('active')) {
                $this.removeClass('active');
                $next.removeClass('next-active');
            } else {
                $containers.removeClass('active next-active');
                $this.addClass('active');
                $next.addClass('next-active');
            }
        });

        return this;
    };
})(jQuery);