<?php
/**
 * Función para renderizar la tarjeta de producto
 * 
 * @param array $product_data Datos del producto a mostrar
 * @param string $template Nombre de la plantilla a utilizar (default, sale)
 * @return string HTML de la tarjeta de producto
 */
function render_product_card($product_data, $template = 'default')
{
    // Validar datos del producto
    if (empty($product_data['id'])) {
        return '';
    }

    // Obtener el producto de WooCommerce
    $product = wc_get_product($product_data['id']);

    if (!$product) {
        return '';
    }

    $rating = $product->get_average_rating();
    $product_data['average_rating'] = number_format((float) $rating, 1, '.', '');

    // Iniciar el buffer de salida
    ob_start();

    // Renderizar la plantilla correspondiente
    if ($template === 'sale') {
        ?>
        <div class="product-card">
            <a href="<?php echo esc_url($product_data['url']); ?>" class="product-preview">
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
                            xlink:href="<?php echo esc_url($product_data['image']); ?>" />
                    </defs>
                </svg>
            </a>
            <div class="product-info">
                <div class="category-rating">
                    <span class="category-info"><?php echo esc_html($product_data['category_name']); ?></span>
                    <span class="rating"><?php echo esc_html($product_data['average_rating']); ?></span>
                </div>
                <div class="course-product-name">
                    <h3><a
                            href="<?php echo esc_url($product_data['url']); ?>"><?php echo esc_html($product_data['name']); ?></a>
                    </h3>
                </div>
                <div class="lessons-count">
                    <span class="counter"><?php echo esc_html($product_data['lesson_count']); ?></span>
                </div>
            </div>
            <div class="buy-product">
                <p class="price">
                    <span class="regular-price"><?php echo wp_kses_post($product_data['regular_price']); ?></span>
                    <span class="sale-price"><?php echo wp_kses_post($product_data['sale_price']); ?></span>
                </p>
                <?php
                // Pasar el producto WooCommerce al template del botón
                $button_product = array(
                    'id' => $product_data['id'],
                    'wc_product' => $product
                );
                include get_template_directory() . '/components/woocommerce/buttons/add-to-cart-var.php';
                ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="product-card">
            <a href="<?php echo esc_url($product_data['url']); ?>" class="product-preview">
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
                            xlink:href="<?php echo esc_url($product_data['image']); ?>" />
                    </defs>
                </svg>
            </a>
            <div class="product-info">
                <div class="category-rating">
                    <span class="category-info"><?php echo esc_html($product_data['category_name']); ?></span>
                    <span class="rating"><?php echo esc_html($product_data['average_rating']); ?></span>
                </div>
                <div class="course-product-name">
                    <h3><a
                            href="<?php echo esc_url($product_data['url']); ?>"><?php echo esc_html($product_data['name']); ?></a>
                    </h3>
                </div>
                <div class="lessons-count">
                    <span class="counter"><?php echo esc_html($product_data['lesson_count']); ?></span>
                </div>
            </div>
            <div class="buy-product">
                <span class="price"><?php echo wp_kses_post($product_data['price']); ?></span>
                <?php
                // Pasar el producto WooCommerce al template del botón
                $button_product = array(
                    'id' => $product_data['id'],
                    'wc_product' => $product
                );
                include get_template_directory() . '/components/woocommerce/buttons/add-to-cart.php';
                ?>
            </div>
        </div>
        <?php
    }

    return ob_get_clean();
}