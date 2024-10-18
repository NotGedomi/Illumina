(function(jQuery) {
    jQuery.fn.dynamicMTop = function(baseElementSelector, targetElementSelector) {
        var $baseElement = jQuery(baseElementSelector);
        var $targetElement = jQuery(targetElementSelector);

        function adjustTop() {
            var baseHeight = $baseElement.outerHeight();
            $targetElement.css('margin-top', baseHeight + 'px');
        }

        // Ajusta la posición inicial
        adjustTop();

        // Ajusta la posición cuando la ventana se redimensiona
        jQuery(window).resize(function() {
            adjustTop();
        });

        // Usa ResizeObserver para detectar cambios en el tamaño del elemento base
        if (typeof ResizeObserver !== 'undefined') {
            var resizeObserver = new ResizeObserver(function() {
                adjustTop();
            });
            resizeObserver.observe($baseElement[0]);
        }
    };

    // Asegúrate de que la función se ejecute solo si se llama explícitamente
    jQuery(document).ready(function() {
        if (typeof window.dynamicMTopParams !== 'undefined') {
            var params = window.dynamicMTopParams;
            jQuery.fn.dynamicMTop(params.base, params.target);
        }
    });
})(jQuery);
