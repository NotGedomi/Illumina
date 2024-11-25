<?php
/**
 * Obtiene los productos más recientes de WooCommerce
 * 
 * @package Illumina
 * @subpackage WooCommerce
 * @param int $limit Número de productos a obtener
 * @param array $args Argumentos adicionales para la consulta
 * @return array Array de productos con sus datos formateados
 */
function get_latest_products($limit = 10, $args = array()) {
    $default_args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            ),
        ),
    );

    $args = wp_parse_args($args, $default_args);
    $query = new WP_Query($args);
    $products = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id = get_the_ID();
            $product = wc_get_product($product_id);
            
            // Obtener precios individuales
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $current_price = $product->get_price();

            // Formatear precios con moneda de WooCommerce
            $current_price = wc_price($current_price);
            
            // Reutilizar funciones existentes
            $product_image = get_product_image($product_id);
            $average_rating = get_product_average_rating($product_id);
            $categories = get_the_terms($product_id, 'product_cat');
            
            // Obtener el número de lecciones
            $course_relation = get_product_course_relation($product_id);
            $lesson_count = 0;
            if ($course_relation && !empty($course_relation['course_id'])) {
                $course_structure = get_course_structure($course_relation['course_id']);
                $lesson_count = $course_structure['lesson_count'];
            }

            $products[] = array(
                'id' => $product_id,
                'name' => get_the_title(),
                'price' => $current_price, // Solo enviamos el precio actual formateado
                'average_rating' => $average_rating,
                'category_name' => !empty($categories) ? $categories[0]->name : '',
                'lesson_count' => $lesson_count,
                'image' => $product_image,
                'url' => get_permalink($product_id)
            );
        }
        wp_reset_postdata();
    }

    return $products;
}