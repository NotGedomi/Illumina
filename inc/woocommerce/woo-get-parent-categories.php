<?php
/**
 * Obtiene solo las categorías padre de productos
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_parent_product_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent' => 0,
        'hide_empty' => false
    ));

    if (is_wp_error($categories)) {
        return array();
    }

    $parent_categories = array();
    foreach ($categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        
        $parent_categories[] = array(
            'id' => $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'count' => $category->count,
            'url' => get_term_link($category->term_id, 'product_cat'),
            'thumbnail' => array(
                'id' => $thumbnail_id,
                'url' => wp_get_attachment_url($thumbnail_id),
                'thumbnail_url' => wp_get_attachment_image_url($thumbnail_id, 'thumbnail'),
                'medium_url' => wp_get_attachment_image_url($thumbnail_id, 'medium')
            )
        );
    }

    return $parent_categories;
}