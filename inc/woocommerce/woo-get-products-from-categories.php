<?php
/**
 * Obtiene los productos de una categoría específica
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_category_products($category_id, $per_page = -1, $page = 1) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id
            )
        )
    );

    $query = new WP_Query($args);
    $products = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            
            $products[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'slug' => $product->get_slug(),
                'price' => $product->get_price(),
                'regular_price' => $product->get_regular_price(),
                'sale_price' => $product->get_sale_price(),
                'description' => $product->get_description(),
                'short_description' => $product->get_short_description(),
                'images' => array(
                    'id' => $product->get_image_id(),
                    'url' => wp_get_attachment_url($product->get_image_id()),
                    'thumbnail_url' => get_the_post_thumbnail_url($product->get_id(), 'thumbnail'),
                    'medium_url' => get_the_post_thumbnail_url($product->get_id(), 'medium')
                ),
                'url' => get_permalink($product->get_id()),
                'average_rating' => $product->get_average_rating(),
                'review_count' => $product->get_review_count(),
                'stock_status' => $product->get_stock_status()
            );
        }
        wp_reset_postdata();
    }

    return array(
        'products' => $products,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages
    );
}