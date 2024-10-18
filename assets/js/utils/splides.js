function inicializarSplide(selector, opciones) {
    jQuery(document).ready(function (jQuery) {
        if (jQuery(selector).length) {
            new Splide(selector, opciones).mount();
        }
    });
}

inicializarSplide('banner-sliders', {
    type: 'slide',
    pagination: true,
    autoplay: true,
});