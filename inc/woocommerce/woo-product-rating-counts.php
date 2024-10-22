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
    $counts = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0
    );

    $reviews = get_approved_comments(array(
        'post_id' => $product_id,
        'type' => 'review'
    ));

    foreach ($reviews as $review) {
        $rating = intval(get_comment_meta($review->comment_ID, 'rating', true));
        if ($rating >= 1 && $rating <= 5) {
            $counts[$rating]++;
        }
    }

    return $counts;
}
