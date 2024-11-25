<?php
/**
 * Configuración y soporte de WooCommerce
 * 
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

// Agregar soporte para WooCommerce
function add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'add_woocommerce_support');

// Asegurar disponibilidad del carrito en AJAX
function load_cart_in_ajax() {
    if (!defined('WOOCOMMERCE_CART')) {
        define('WOOCOMMERCE_CART', true);
    }
    WC()->cart->get_cart();
}
add_action('wp_ajax_wc_add_to_cart', 'load_cart_in_ajax', 1);
add_action('wp_ajax_nopriv_wc_add_to_cart', 'load_cart_in_ajax', 1);

// Endpoint para agregar al carrito
function handle_add_to_cart_ajax() {
    check_ajax_referer('wc-add-to-cart-nonce', 'security');
    
    $product_id = absint($_POST['product_id']);
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    
    ob_start();
    
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
        ob_clean();
        
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        
        $fragments = array(
            'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
        );
        
        wp_send_json_success(array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash(),
            'cart_quantity' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        ob_clean();
        $notices = wc_get_notices('error');
        wc_clear_notices();
        wp_send_json_error(array(
            'message' => !empty($notices) ? reset($notices)['notice'] : __('Error al añadir al carrito', 'woocommerce')
        ));
    }
    wp_die();
}
add_action('wp_ajax_wc_add_to_cart', 'handle_add_to_cart_ajax');
add_action('wp_ajax_nopriv_wc_add_to_cart', 'handle_add_to_cart_ajax');

// Endpoint para remover del carrito
function handle_remove_from_cart_ajax() {
    check_ajax_referer('wc-add-to-cart-nonce', 'security');
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    
    if ($cart_item_key && WC()->cart->remove_cart_item($cart_item_key)) {
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        
        $fragments = array(
            'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
        );
        
        wp_send_json(array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash(),
            'cart_is_empty' => WC()->cart->is_empty()
        ));
    }
    wp_die();
}
add_action('wp_ajax_remove_from_cart', 'handle_remove_from_cart_ajax');
add_action('wp_ajax_nopriv_remove_from_cart', 'handle_remove_from_cart_ajax');

// Endpoint para actualizar cantidad
function handle_update_cart_item_quantity() {
    check_ajax_referer('wc-add-to-cart-nonce', 'security');
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = absint($_POST['quantity']);
    
    if ($cart_item_key && WC()->cart->set_quantity($cart_item_key, $quantity)) {
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        
        $fragments = array(
            'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
        );
        
        wp_send_json_success(array(
            'fragments' => $fragments
        ));
    }
    wp_die();
}
add_action('wp_ajax_update_cart_item_quantity', 'handle_update_cart_item_quantity');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'handle_update_cart_item_quantity');

// Actualizar fragmentos del carrito
function update_cart_fragments($fragments) {
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();
    
    $fragments['div.widget_shopping_cart_content'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';
    
    ob_start();
    ?>
    <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'update_cart_fragments');

// Prevenir compras duplicadas
function prevent_duplicate_purchase($passed, $product_id) {
    if (is_user_logged_in() && has_user_bought_product($product_id)) {
        wc_add_notice(__('Ya has adquirido este producto.', 'woocommerce'), 'error');
        return false;
    }
    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'prevent_duplicate_purchase', 10, 2);