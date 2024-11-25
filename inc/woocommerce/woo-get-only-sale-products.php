<?php
/**
 * Obtiene los productos en descuento de WooCommerce
 * 
 * @package Illumina
 * @subpackage WooCommerce
 * @param int $limit Número de productos a obtener
 * @param array $args Argumentos adicionales para la consulta
 * @return array Array de productos en descuento con sus datos formateados
 */
function get_sale_products($limit = 10, $args = array()) {
    // Obtener IDs de productos en descuento
    $sale_products = wc_get_product_ids_on_sale();

    if (empty($sale_products)) {
        return array();
    }

    $default_args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post__in' => $sale_products,
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

            if (!$product || !$product->is_on_sale()) {
                continue;
            }

            // Obtener precios individuales
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();

            // Calcular porcentaje de descuento
            $discount_percentage = 0;
            if ($regular_price > 0) {
                $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            }

            // Formatear precios con moneda de WooCommerce
            $formatted_regular_price = wc_price($regular_price);
            $formatted_sale_price = wc_price($sale_price);

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
                'regular_price' => $formatted_regular_price,
                'sale_price' => $formatted_sale_price,
                'discount_percentage' => $discount_percentage,
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