(function(jQuery) {
    jQuery.fn.stylingNavOnHover = function(triggerSelector, submenuSelector) {
        return this.each(function() {
            var $triggerItems = jQuery(this).find(triggerSelector);
            var currentSubMenu = null;

            $triggerItems.each(function() {
                var $menuItem = jQuery(this);
                var $submenu = $menuItem.find(submenuSelector);

                $menuItem.on('mouseover', function() {
                    if (currentSubMenu && currentSubMenu[0] !== $submenu[0]) {
                        hideSubMenu(currentSubMenu);
                    }
                    showSubMenu($submenu);
                    currentSubMenu = $submenu;
                });

                $submenu.on('mouseover', function() {
                    showSubMenu($submenu);
                    currentSubMenu = $submenu;
                });

                $submenu.on('mouseout', function() {
                    hideSubMenu($submenu);
                });
            });

            function showSubMenu($submenu) {
                clearTimeout($submenu.data('hideTimer'));
                $submenu.css({
                    'opacity': '1',
                    'pointer-events': 'auto',
                    'visibility': 'visible'
                });
            }

            function hideSubMenu($submenu) {
                var hideTimer = setTimeout(function() {
                    $submenu.css({
                        'opacity': '0',
                        'pointer-events': 'none',
                        'visibility': 'hidden'
                    });
                }, 100); // Tiempo para ocultar el submenú
                $submenu.data('hideTimer', hideTimer);
            }
        });
    };
})(jQuery);
