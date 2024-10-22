<?php
/**
 * Obtiene los atributos personalizados del producto de WooCommerce.
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_attributes($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return array();
    }

    $attributes = array();
    foreach ($product->get_attributes() as $attribute_name => $attribute) {
        $attribute_label = wc_attribute_label($attribute_name);
        $values = $attribute->is_taxonomy() ?
            array_map(function ($term_id) {
                $term = get_term($term_id);
                return $term ? $term->name : '';
            }, $attribute->get_options()) :
            $attribute->get_options();

        $attributes[] = array(
            'label' => $attribute_label,
            'values' => $values
        );
    }
    return $attributes;
}