<?php
/**
 * Obtiene los datos básicos de un producto de WooCommerce.
 * Incluye precio, precio regular, precio de venta y categorías.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_data($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return array();
    }
 
    $data = array(
        'price' => $product->get_price_html(),
        'regular_price' => wc_price($product->get_regular_price()),
        'sale_price' => $product->get_sale_price() ? wc_price($product->get_sale_price()) : '',
        'categories' => wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names')),
        'related_products' => array(
            'upsells' => array(),
            'cross_sells' => array()
        )
    );
 
    // Procesar upsells
    foreach ($product->get_upsell_ids() as $upsell_id) {
        $upsell_course_relation = get_product_course_relation($upsell_id);
        if ($upsell_course_relation) {
            $upsell_instructor = get_course_instructor_info($upsell_course_relation['course_id']);
            $data['related_products']['upsells'][] = array(
                'id' => $upsell_id,
                'name' => $upsell_course_relation['course_name'],
                'course_id' => $upsell_course_relation['course_id'],
                'instructor_name' => $upsell_instructor['instructor_name'] ?? 'Instructor no especificado',
                'rating' => get_product_average_rating($upsell_id),
                'categories' => wp_get_post_terms($upsell_id, 'product_cat', array('fields' => 'names')),
                'image' => get_product_image($upsell_id)
            );
        }
    }
 
    // Procesar cross-sells
    foreach ($product->get_cross_sell_ids() as $cross_sell_id) {
        $cross_sell = wc_get_product($cross_sell_id);
        if ($cross_sell) {
            $data['related_products']['cross_sells'][] = array(
                'id' => $cross_sell_id,
                'name' => $cross_sell->get_name(),
                'price' => $cross_sell->get_price_html(),
                'image' => wp_get_attachment_image_url($cross_sell->get_image_id(), 'full')
            );
        }
    }
 
    return $data;
 }