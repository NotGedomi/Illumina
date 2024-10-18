<?php
/**
 * Obtiene los datos básicos del producto asociado al programa educativo (curso o diplomado)
 *
 * @param int $product_id ID del producto
 * @return array Datos del producto incluyendo precio, imagen y categorías
 */
function get_program_product_data($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return array();
    }

    return array(
        'product_price' => wc_price($product->get_price()),
        'sale_price' => wc_price($product->get_sale_price()),
        'product_image' => get_product_image($product),
        'categories' => wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names')),
    );
}

/**
 * Obtiene la URL de la imagen principal del producto
 *
 * @param WC_Product $product Objeto del producto
 * @return string URL de la imagen o cadena vacía si no hay imagen
 */
function get_product_image($product) {
    $image_id = $product->get_image_id();
    if ($image_id) {
        $image_src = wp_get_attachment_image_src($image_id, 'full');
        return $image_src ? $image_src[0] : '';
    }
    return '';
}