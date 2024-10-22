<?php
/**
 * Obtiene las categorías de productos más recientes
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_recent_product_categories($limit = 5) {
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'number' => $limit,
        'orderby' => 'term_id', // term_id es secuencial, por lo que los más altos son los más recientes
        'order' => 'DESC'
    ));

    if (is_wp_error($categories)) {
        return array();
    }

    $recent_categories = array();
    foreach ($categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        
        $recent_categories[] = array(
            'id' => $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'parent_id' => $category->parent,
            'count' => $category->count,
            'url' => get_term_link($category->term_id, 'product_cat'),
            'date_created' => get_term_meta($category->term_id, 'created', true),
            'thumbnail' => array(
                'id' => $thumbnail_id,
                'url' => wp_get_attachment_url($thumbnail_id),
                'thumbnail_url' => wp_get_attachment_image_url($thumbnail_id, 'thumbnail'),
                'medium_url' => wp_get_attachment_image_url($thumbnail_id, 'medium')
            )
        );
    }

    return $recent_categories;
}