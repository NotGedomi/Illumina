<?php
/**
 * Obtiene las reseñas del producto con todos sus detalles.
 *
 * @package Illumina
 * @subpackage WooCommerce
 * @param int $product_id ID del producto
 * @return array Array de reseñas formateadas
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_reviews($product_id) {
    $reviews = get_comments(array(
        'post_id' => $product_id,
        'status' => 'approve',
        'type' => 'review',
        'orderby' => 'comment_date',
        'order' => 'DESC'
    ));

    $formatted_reviews = array();
    
    foreach ($reviews as $review) {
        // Obtener datos del usuario
        $user_id = $review->user_id;
        $display_name = $review->comment_author;
        
        if ($user_id) {
            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name = get_user_meta($user_id, 'last_name', true);
            
            if (!empty($first_name) && !empty($last_name)) {
                $display_name = $first_name . ' ' . $last_name;
            } elseif (!empty($first_name)) {
                $display_name = $first_name;
            }
        }

        // Obtener avatar
        $avatar_url = '';
        if ($user_id) {
            $custom_image_id = get_user_meta($user_id, 'instructor_profile_image_id', true);
            if ($custom_image_id) {
                $image_url = wp_get_attachment_image_src($custom_image_id, 'thumbnail');
                if ($image_url) {
                    $avatar_url = $image_url[0];
                }
            }
        }
        
        if (empty($avatar_url)) {
            $avatar_url = get_avatar_url($review->comment_author_email, array('size' => 96));
        }

        // Formatear fecha
        $fecha_formateada = date_i18n('j F, Y', strtotime($review->comment_date));

        $formatted_reviews[] = array(
            'id' => $review->comment_ID,
            'rating' => number_format((float)get_comment_meta($review->comment_ID, 'rating', true), 1),
            'author' => $review->comment_author,
            'display_name' => $display_name,
            'user_id' => $user_id,
            'author_image' => $avatar_url,
            'date' => $fecha_formateada,
            'content' => $review->comment_content,
            'verified' => wc_review_is_from_verified_owner($review->comment_ID)
        );
    }

    return $formatted_reviews;
}