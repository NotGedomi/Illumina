<?php
/**
 * Funciones optimizadas para encontrar y obtener datos de categorías de productos
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Obtiene una categoría de producto y sus subcategorías por slug
 * 
 * @param string $slug Slug de la categoría
 * @return array|null Datos de la categoría y sus subcategorías
 */
function get_product_category_with_children($slug) {
    $term = get_term_by('slug', $slug, 'product_cat');
    
    if (!$term) {
        return null;
    }

    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);

    return array(
        'main' => array(
            'id' => $term->term_id,
            'name' => $term->name,
            'slug' => $term->slug,
            'url' => get_term_link($term),
            'description' => $term->description,
            'count' => $term->count,
            'thumbnail' => array(
                'id' => $thumbnail_id,
                'url' => wp_get_attachment_url($thumbnail_id),
                'thumbnail_url' => wp_get_attachment_image_url($thumbnail_id, 'thumbnail'),
                'medium_url' => wp_get_attachment_image_url($thumbnail_id, 'medium')
            )
        ),
        'children' => get_child_product_categories($term->term_id)
    );
}