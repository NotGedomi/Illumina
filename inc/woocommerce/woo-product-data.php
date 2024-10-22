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

    return array(
        'price' => $product->get_price_html(),
        'regular_price' => wc_price($product->get_regular_price()),
        'sale_price' => $product->get_sale_price() ? wc_price($product->get_sale_price()) : '',
        'categories' => wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names')),
    );
}
