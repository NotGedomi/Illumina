(function(jQuery) {
    jQuery.fn.dynamicTop = function(baseElementSelector, targetElementSelector) {
        var $baseElement = jQuery(baseElementSelector);
        var $targetElement = jQuery(targetElementSelector);

        function adjustTop() {
            var baseHeight = $baseElement.outerHeight();
            $targetElement.css('top', baseHeight + 'px');
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
        if (typeof window.dynamicTopParams !== 'undefined') {
            var params = window.dynamicTopParams;
            jQuery.fn.dynamicTop(params.base, params.target);
        }
    });
})(jQuery);
