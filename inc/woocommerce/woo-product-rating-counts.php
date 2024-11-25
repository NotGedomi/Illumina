<?php
/**
 * Obtiene el conteo de calificaciones por número de estrellas del producto.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_rating_counts($product_id) {
    $product = wc_get_product($product_id);
    
    if (!$product) {
        return array_fill(1, 5, 0);
    }

    // Usar la función nativa de WooCommerce para obtener las calificaciones
    return $product->get_rating_counts();
}