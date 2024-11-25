<?php
/**
 * Template para la tarjeta de producto en promoción
 * 
 * @package Illumina
 * @subpackage Components
 * @var array $product Datos del producto a mostrar
 */

if (!defined('ABSPATH')) {
    exit;
}

// Asegurarse de que tenemos un ID de producto válido
$product_id = isset($product['id']) ? $product['id'] : 0;
if (!$product_id) {
    return;
}

// Obtener el producto de WooCommerce para el botón de agregar al carrito
$wc_product = wc_get_product($product_id);
if (!$wc_product) {
    return;
}
?>
<div class="product-card">
    <a href="<?php echo esc_url($product['url']); ?>" class="product-preview">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="304" height="182"
            viewBox="0 0 304 182" fill="none">
            <path
                d="M0.435913 24.2051C0.435913 11.1768 10.9974 0.615356 24.0257 0.615356H279.974C293.003 0.615356 303.564 11.1768 303.564 24.2051V157.44C303.564 171.371 291.556 182.268 277.69 180.919L21.7418 156.021C9.65517 154.846 0.435913 144.686 0.435913 132.542V24.2051Z"
                fill="url(#pattern0_1527_801)" />
            <defs>
                <pattern id="pattern0_1527_801" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_1527_801" transform="matrix(0.000419119 0 0 0.000694927 -0.0347964 0)" />
                </pattern>
                <image id="image0_1527_801" width="2552" height="1439"
                    xlink:href="<?php echo esc_url($product['image']); ?>" />
            </defs>
        </svg>
    </a>
    <div class="product-info">
        <div class="category-rating">
            <span class="category-info"><?php echo esc_html($product['category_name']); ?></span>
            <span class="rating"><?php echo esc_html($product['average_rating']); ?></span>
        </div>
        <div class="course-product-name">
            <h3><a href="<?php echo esc_url($product['url']); ?>"><?php echo esc_html($product['name']); ?></a></h3>
        </div>
        <div class="lessons-count">
            <span class="counter"><?php echo esc_html($product['lesson_count']); ?></span>
        </div>
    </div>
    <div class="buy-product">
        <p class="price">
            <span class="regular-price"><?php echo wp_kses_post($product['regular_price']); ?></span>
            <span class="sale-price"><?php echo wp_kses_post($product['sale_price']); ?></span>
        </p>
        <?php
        // Pasar el producto WooCommerce al template del botón
        $button_product = array(
            'id' => $product_id,
            'wc_product' => $wc_product
        );
        include get_template_directory() . '/components/woocommerce/buttons/add-to-cart-var.php';
        ?>
    </div>
</div>