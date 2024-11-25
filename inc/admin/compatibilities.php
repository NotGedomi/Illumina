<?php
// Compatibilidades de WooCommerce y Sensei para el theme
function illumina_compatibilities() {
    // Añade soporte para Sensei LMS
    add_theme_support('sensei');
    
    // Añade soporte para WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'illumina_compatibilities');