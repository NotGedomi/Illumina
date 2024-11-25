function inicializarSplide(selector, opciones) {
    jQuery(document).ready(function (jQuery) {
        jQuery(selector).each(function () {
            new Splide(this, opciones).mount(window.splide ? window.splide.Extensions : null);
        });
    });
}

// Banner principal
inicializarSplide('#banner-sliders', {
    type: 'loop',
    pagination: true,
    autoplay: true,
});

// Cursos
inicializarSplide('.courses-sliders', {
    type: 'loop',
    autoplay: true,
    arrows: false,
    pagination: false,
    perPage: 4,
    gap: '1.2rem',
    padding: { left: '0.5rem', right: '0.5rem' },
    breakpoints: {
        1000: {
            perPage: 3,
        }
    }
});

// Graduados
inicializarSplide('.graduates-sliders', {
    type: 'loop',
    autoplay: true,
    arrows: false,
    pagination: false,
    perPage: 4,
    gap: '1.2rem',
    padding: { left: '0.5rem', right: '0.5rem' },
    breakpoints: {
        1000: {
            perPage: 3,
        }
    }
});

// Nuestros cursos
inicializarSplide('#our-courses', {
    type: 'slide',
    arrows: false,
    pagination: false,
    autoplay: true,
    perPage: 4,
    gap: '1.2rem',
    breakpoints: {
        1480: {
            perPage: 3,
        },
        1200: {
            perPage: 2,
        },
        768: {
            arrows: true,
            perPage: 1,
        }
    }
});

// Colección de entidades con grid
inicializarSplide('.entitys-collection', {
    type: 'slide',
    arrows: false,
    autoplay: true,
    gap: '2rem',
    perPage: 1,
    grid: {
        dimensions: [[2, 5]],
        gap: {
            row: '2rem',
            col: '2rem',
        }
    },
});

inicializarSplide('#hot-products', {
    type: 'slide',
    arrows: false,
    pagination: false,
    autoplay: true,
    perPage: 3,
    gap: '1.2rem',
    breakpoints: {
        1200: {
            perPage: 2,
        },
        768: {
            arrows: true,
            perPage: 1,
        }
    }
});

// Banner principal
inicializarSplide('#home-reviews', {
    type: 'loop',
    drag: true,
    pagination: true,
    autoplay: true,
    trimSpace: false,
    focus: 'center',
    gap: '0.2rem',
    perPage: 3,
    padding: {
        right: '15%',
    }
});

// Banner principal
inicializarSplide('#single-product-reviews', {
    type: 'loop',
    drag: true,
    pagination: true,
    autoplay: true,
    trimSpace: false,
    focus: 'center',
    gap: '0.2rem',
    perPage: 3,
    padding: {
        right: '15%',
    }
});

// Productos Relacionados
inicializarSplide('#related-products', {
    type: 'loop',
    drag: true,
    pagination: false,
    arrows: false,
    autoplay: true,
    trimSpace: false,
    focus: 'center',
    gap: '0.2rem',
    perPage: 3,
});

// Instructores
inicializarSplide('#instructors-team', {
    type: 'loop',
    drag: true,
    pagination: false,
    arrows: false,
    autoplay: true,
    trimSpace: false,
    gap: '0.2rem',
    perPage: 4,
});