<?php
/**
 * Maneja la lógica del carrito flotante y botones de agregar al carrito
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Verifica si un usuario ya ha comprado un producto
 */
function has_user_bought_product($product_id, $user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    if ($user_id === 0) return false;

    $customer_orders = wc_get_orders(array(
        'customer_id' => $user_id,
        'status' => array('wc-completed'),
        'limit' => -1
    ));

    foreach ($customer_orders as $order) {
        foreach ($order->get_items() as $item) {
            if ($item->get_product_id() == $product_id) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Obtiene el estado del producto para el botón
 */
function get_product_button_state($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) return false;

    return array(
        'in_cart' => WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product_id)),
        'is_in_stock' => $product->is_in_stock(),
        'already_bought' => has_user_bought_product($product_id),
        'is_logged_in' => is_user_logged_in(),
        'course_data' => get_product_course_relation($product_id)
    );
}

// Agregar configuración al script del carrito flotante
function add_float_cart_script_config() {
    if (!is_admin()) {
        wp_localize_script('wc-float-cart', 'wc_float_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
            'cart_url' => wc_get_cart_url(),
            'is_cart' => is_cart(),
            'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add'),
            'i18n' => array(
                'empty_cart' => __('Tu carrito está vacío', 'woocommerce'),
                'confirm_remove' => __('¿Estás seguro de querer eliminar este producto?', 'woocommerce'),
                'cart_error' => __('Ocurrió un error al actualizar el carrito', 'woocommerce'),
                'in_cart' => __('En el carrito', 'woocommerce'),
                'add_to_cart' => __('Agregar', 'woocommerce')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'add_float_cart_script_config', 99);

// Asegurar que WC()->cart está disponible en AJAX
add_action('wp_ajax_nopriv_check_cart', 'ensure_cart_is_loaded');
add_action('wp_ajax_check_cart', 'ensure_cart_is_loaded');
function ensure_cart_is_loaded() {
    if (!defined('WOOCOMMERCE_CART')) {
        define('WOOCOMMERCE_CART', true);
    }
    WC()->cart->get_cart();
}