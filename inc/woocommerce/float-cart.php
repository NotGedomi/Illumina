<?php
/**
 * Obtiene los datos para el mini-carrito flotante
 *
 * @return array Datos del mini-carrito
 */
function get_mini_cart_data() {
    if (!function_exists('WC')) {
        return array();
    }

    $cart = WC()->cart;
    $cart_items = array();

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $product->get_id();

        $item = array(
            'name' => $product->get_name(),
            'price' => wc_price($product->get_price()),
            'quantity' => $cart_item['quantity'],
            'image' => get_the_post_thumbnail_url($product_id, 'thumbnail'),
            'remove_url' => wc_get_cart_remove_url($cart_item_key),
        );

        // Obtener la categoría del producto
        $categories = get_the_terms($product_id, 'product_cat');
        if (!empty($categories) && !is_wp_error($categories)) {
            $item['category'] = $categories[0]->name;
        } else {
            $item['category'] = '';
        }

        $cart_items[] = $item;
    }

    return array(
        'items' => $cart_items,
        'total' => wc_price($cart->total),
        'checkout_url' => wc_get_checkout_url(),
        'cart_url' => wc_get_cart_url(),
    );
}