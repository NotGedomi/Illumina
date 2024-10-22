<?php
/**
 * Obtiene las reseñas del producto con sus detalles.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_reviews($product_id) {
    $reviews = get_comments(array(
        'post_id' => $product_id,
        'status' => 'approve',
        'type' => 'review'
    ));

    $formatted_reviews = array();
    foreach ($reviews as $review) {
        $formatted_reviews[] = array(
            'id' => $review->comment_ID,
            'rating' => get_comment_meta($review->comment_ID, 'rating', true),
            'author' => $review->comment_author,
            'date' => $review->comment_date,
            'content' => $review->comment_content
        );
    }

    return $formatted_reviews;
}
