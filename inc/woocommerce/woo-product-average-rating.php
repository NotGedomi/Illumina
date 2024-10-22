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
    $rating_counts = get_product_rating_counts($product_id);
    $total_rating = array_sum(array_map(function($count, $star) { 
        return $count * $star; 
    }, $rating_counts, array_keys($rating_counts)));
    
    $total_count = array_sum($rating_counts);
    return $total_count > 0 ? round($total_rating / $total_count, 1) : 0;
}
