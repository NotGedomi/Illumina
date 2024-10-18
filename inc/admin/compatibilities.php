<?php
// Compatibilidades de WooCommerce y Sensei para el theme
function illumina_compatibilities() {
    // Añade soporte para Sensei LMS
    add_theme_support('sensei');
    
    // Añade soporte para WooCommerce
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'illumina_compatibilities');