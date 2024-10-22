<?php
/**
 * Obtiene la URL de la imagen principal del producto de WooCommerce.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_image($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return '';
    }

    $image_id = $product->get_image_id();
    if ($image_id) {
        $image_src = wp_get_attachment_image_src($image_id, 'full');
        return $image_src ? $image_src[0] : '';
    }
    return '';
}
