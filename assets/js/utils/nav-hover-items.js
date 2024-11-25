(function(jQuery) {
    jQuery.fn.stylingNavOnHover = function(triggerSelector, submenuSelector) {
        return this.each(function() {
            var $triggerItems = jQuery(this).find(triggerSelector);
            var currentSubMenu = null;

            $triggerItems.each(function() {
                var $menuItem = jQuery(this);
                var $submenu = $menuItem.find(submenuSelector);

                // Handle menu item hover
                $menuItem.on('mouseenter', function() {
                    if (currentSubMenu && currentSubMenu[0] !== $submenu[0]) {
                        hideSubMenu(currentSubMenu);
                    }
                    showSubMenu($submenu);
                    currentSubMenu = $submenu;
                });

                $menuItem.on('mouseleave', function(e) {
                    // Check if the mouse is moving to the submenu
                    var toElement = e.toElement || e.relatedTarget;
                    if (!$submenu.is(toElement) && !$submenu.has(toElement).length) {
                        hideSubMenu($submenu);
                    }
                });

                // Handle submenu hover
                $submenu.on('mouseenter', function() {
                    showSubMenu($submenu);
                    currentSubMenu = $submenu;
                });

                $submenu.on('mouseleave', function(e) {
                    // Check if the mouse is moving back to the menu item
                    var toElement = e.toElement || e.relatedTarget;
                    if (!$menuItem.is(toElement) && !$menuItem.has(toElement).length) {
                        hideSubMenu($submenu);
                    }
                });
            });

            function showSubMenu($submenu) {
                clearTimeout($submenu.data('hideTimer'));
                $submenu
                    .css({
                        'opacity': '1',
                        'pointer-events': 'auto',
                        'visibility': 'visible'
                    })
                    .addClass('active'); // Add active class to control indicator visibility
            }

            function hideSubMenu($submenu) {
                var hideTimer = setTimeout(function() {
                    $submenu
                        .css({
                            'opacity': '0',
                            'pointer-events': 'none',
                            'visibility': 'hidden'
                        })
                        .removeClass('active'); // Remove active class when hiding
                }, 100); // Increased slightly to make the transition smoother
                $submenu.data('hideTimer', hideTimer);
            }
        });
    };
})(jQuery);