<?php
/**
 * Calcula el promedio de calificaciones del producto.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_average_rating($product_id) {
    $product = wc_get_product($product_id);
    
    if (!$product) {
        return '0.0';
    }

    // Obtener el rating y formatearlo a un decimal
    $rating = $product->get_average_rating();
    return number_format((float)$rating, 1, '.', '');
}