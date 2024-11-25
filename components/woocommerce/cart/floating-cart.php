<?php
/**
 * Template para el carrito flotante
 * 
 * @package Illumina
 * @subpackage Components
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_mini_cart');
?>
<style>
    .custom-floating-cart {
        margin-block: auto;
        display: flex;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        align-items: center;
        height: 100%;
        width: 100%;
        opacity: 1;
        z-index: 1000000;
        transition: opacity 0.3s ease, visibility 0s 0.3s; /* Añadir transición de opacidad */

        &.hidden {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
        }

        &::before {
            content: '';
            width: 100%;
            height: 100%;
            position: fixed;
            background-color: var(--purple-cold);
            opacity: 0.6;
            z-index: -1;
            left: 0;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            background-color: var(--purple-warm);
            height: 80%;
            justify-content: center;
            padding: 2.5rem;
            border-top-left-radius: 3rem;
            border-bottom-left-radius: 3rem;
            max-width: 30rem;
            width: 100%;
            right: 0;
            position: relative;
            margin-left: auto;
            gap: 1rem;

            .close-cart {
                display: flex;
                aspect-ratio: 1 / 1;
                width: 3.5rem;
                height: 3.5rem;
                background-position: center;
                background-size: contain;
                background-repeat: no-repeat;
                background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1NiIgaGVpZ2h0PSI1NiIgdmlld0JveD0iMCAwIDU2IDU2IiBmaWxsPSJub25lIj4KPGNpcmNsZSBjeD0iMjgiIGN5PSIyOCIgcj0iMjgiIGZpbGw9IiNFNEFDNUIiLz4KPHJlY3QgeD0iMTYuNjI1IiB5PSIzNy43MTU5IiB3aWR0aD0iMjguNjM2NiIgaGVpZ2h0PSI4LjM1MjM1IiByeD0iMy41Nzk1OCIgdHJhbnNmb3JtPSJyb3RhdGUoLTU1LjkxMSAxNi42MjUgMzcuNzE1OSkiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHdpZHRoPSIyOC42MzY2IiBoZWlnaHQ9IjguMzUyMzUiIHJ4PSIzLjU3OTU4IiB0cmFuc2Zvcm09Im1hdHJpeCgtMC41NjA0OCAtMC44MjgxNjggLTAuODI4MTY4IDAuNTYwNDggMzkuNTkzOCAzNy43MTU5KSIgZmlsbD0id2hpdGUiLz4KPC9zdmc+);
                position: absolute;
                left: -1.7rem;
            }

            .content {
                display: flex;
                width: 100%;
                height: 100%;
                flex-direction: column;
                justify-content: center;

                .title {
                    display: flex;

                    h4 {
                        font-size: 1.563rem;
                        color: var(--yellow);
                        font-family: var(--co-bold);
                    }
                }

                .items {
                    display: flex;
                    flex-direction: column;
                    height: 50%;
                    overflow: hidden;
                    overflow-y: auto;
                    gap: 1rem;
                    padding-right: 0.5rem;
                    padding-block: 0.5rem;

                    &::-webkit-scrollbar {
                        width: 0.7vw;
                    }

                    &::-webkit-scrollbar-track {
                        background-color: transparent;
                    }

                    &::-webkit-scrollbar-thumb {
                        background-color: var(--purple-warm);
                        border-radius: 3px;
                        border: 1px solid white;
                    }


                    .mini-card {
                        display: flex;
                        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
                        border-radius: 1rem;
                        background-color: var(--white);

                        .item {
                            display: flex;
                            width: 100%;
                            height: 100%;
                            padding: 1.2rem 1rem;
                            gap: 1rem;

                            .left {
                                display: flex;
                                flex-basis: 30%;

                                .prod-preview {
                                    aspect-ratio: 1 / 1;
                                    overflow: hidden;
                                    display: flex;
                                    border-radius: 0.8rem;
                                    width: 100%;

                                    img {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        object-position: center;
                                    }
                                }
                            }

                            .right {
                                display: flex;
                                flex-basis: 70%;

                                .prod-data {
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    justify-content: center;
                                    gap: 0.2rem;

                                    .prod-cat {
                                        display: flex;
                                        background-color: var(--purple-warm);
                                        padding: 0.2rem 0.6rem;
                                        width: max-content;
                                        color: var(--white);
                                        font-family: var(--co-bold);
                                        border-radius: .5rem;
                                        font-size: 0.938rem;
                                    }

                                    .prod-name {
                                        display: flex;
                                        color: var(--purple-cold);
                                        font-size: 1.125rem;
                                        font-family: var(--co-bold);
                                        line-height: normal;
                                    }

                                    .prices {
                                        display: flex;
                                        gap: 0.4rem;
                                        align-items: baseline;

                                        .sale-price {
                                            font-size: 1.25rem;
                                            color: var(--yellow);
                                            font-family: var(--co-bold);
                                            line-height: normal;
                                        }

                                        .regular-price {
                                            font-family: var(--co-medium);
                                            font-size: 0.938rem;
                                            line-height: normal;
                                            color: var(--purple-warm);
                                            opacity: 0.6;
                                            text-decoration: line-through;
                                        }
                                    }
                                }

                                .delete-button-container {
                                    display: flex;
                                    width: max-content;
                                    align-items: center;
                                    padding-inline: 0.5rem;

                                    #delete-button {
                                        cursor: pointer;
                                        width: 2rem;
                                        height: 2rem;
                                        background-color: transparent;
                                        background-repeat: no-repeat;
                                        background-position: center;
                                        background-position: center;
                                        background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMiIgaGVpZ2h0PSIyNSIgdmlld0JveD0iMCAwIDIyIDI1IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTcuMDA4OTcgMS44MTE3Nkw2LjczOTkxIDIuNDQzMTRIMi40MzQ5OEMxLjYyNzggMi40NDMxNCAxIDMuMDc0NTEgMSAzLjg4NjI3QzEgNC42OTgwNCAxLjYyNzggNS4zMjk0MSAyLjQzNDk4IDUuMzI5NDFIMTkuNTY1QzIwLjM3MjIgNS4zMjk0MSAyMSA0LjY5ODA0IDIxIDMuODg2MjdDMjEgMy4wNzQ1MSAyMC4zNzIyIDIuNDQzMTQgMTkuNTY1IDIuNDQzMTRIMTUuMjYwMUwxNC45MDEzIDEuODExNzZDMTQuNjMyMyAxLjM2MDc4IDE0LjE4MzkgMSAxMy42NDU3IDFIOC4yNjQ1N0M3LjgxNjE0IDEgNy4yNzgwMyAxLjI3MDU5IDcuMDA4OTcgMS44MTE3NlpNMTkuNTY1IDYuNzcyNTVIMi40MzQ5OEwzLjQyMTUyIDIyLjAxNTdDMy40MjE1MiAyMy4wOTggNC40MDgwNyAyNCA1LjQ4NDMxIDI0SDE2LjUxNTdDMTcuNjgxNiAyNCAxOC41Nzg1IDIzLjA5OCAxOC42NjgyIDIyLjAxNTdMMTkuNTY1IDYuNzcyNTVaIiBzdHJva2U9IiM2MTMyODQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIi8+Cjwvc3ZnPg==");
                                    }
                                }
                            }
                        }
                    }
                }

                .resume {
                    display: flex;
                    width: 100%;
                    padding-block: 1rem 0.6rem;
                    border-top: 2px solid #ffffffd6;

                    .total {
                        width: 100%;
                        display: flex;
                        justify-content: space-between;
                        font-size: 1.125rem;
                        font-family: var(--nu-bold);
                        color: var(--white);

                        >span {

                            &.total-price {}
                        }
                    }
                }

                .buttons {
                    justify-self: center;
                    align-items: center;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    gap: 0.6rem;

                    .buy-now {
                        display: flex;
                        text-align: center;
                        align-items: center;
                        justify-content: center;
                        color: var(--white);
                        background-color: var(--yellow);
                        border-radius: 0.625rem;
                        width: max-content;
                        padding: 0.6rem 1rem;
                        font-family: var(--nu-semibold);
                        font-size: 1.428rem;
                        cursor: pointer;
                        transition: var(--anim-low);

                        &:hover {
                            color: var(--yellow);
                            background-color: var(--yellow-clear);
                        }
                    }

                    .pay-later {
                        font-family: var(--nu-regular);
                        color: var(--white);
                        font-size: 1.188rem;
                        padding-block: 0.8rem;
                    }
                }
            }


        }
    }
</style>
<aside class="custom-floating-cart">
    <div class="main-container">
        <button class="close-cart"></button>
        <div class="content">
            <div class="title">
                <h4><?php esc_html_e('Mi carrito de compras', 'woocommerce'); ?></h4>
            </div>
            <div class="items">
                <?php if (!WC()->cart->is_empty()): ?>
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>
                        <?php
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                            $product_name = $_product->get_name();
                            $product_permalink = $_product->is_visible() ? $_product->get_permalink() : '';
                            $product_thumbnail = $_product->get_image();
                            $product_price = WC()->cart->get_product_price($_product);
                            $regular_price = $_product->get_regular_price();
                            $sale_price = $_product->get_sale_price();
                            $product_category = wc_get_product_category_list($product_id);
                            ?>
                            <div class="mini-card">
                                <div class="item">
                                    <div class="left">
                                        <div class="prod-preview">
                                            <a href="<?php echo esc_url($product_permalink); ?>">
                                                <?php echo $product_thumbnail; ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="prod-data">
                                            <span class="prod-cat"><?php echo $product_category; ?></span>
                                            <span class="prod-name"><?php echo esc_html($product_name); ?></span>
                                            <div class="prices">
                                                <?php if ($sale_price): ?>
                                                    <span class="sale-price"><?php echo wc_price($sale_price); ?></span>
                                                    <span class="regular-price"><?php echo wc_price($regular_price); ?></span>
                                                <?php else: ?>
                                                    <span class="sale-price"><?php echo wc_price($regular_price); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="delete-button-container">
                                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                                class="remove remove_from_cart_button"
                                                aria-label="<?php esc_attr_e('Remove this item', 'woocommerce'); ?>">
                                                &times;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="woocommerce-mini-cart__empty-message">
                        <?php esc_html_e('No products in the cart.', 'woocommerce'); ?></p>
                <?php endif; ?>
            </div>
            <div class="resume">
                <div class="total">
                    <span><?php esc_html_e('Total estimado', 'woocommerce'); ?></span>
                    <span class="total-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                </div>
            </div>
            <div class="buttons">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                    class="buy-now"><?php esc_html_e('Comprar ahora', 'woocommerce'); ?></a>
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                    class="pay-later"><?php esc_html_e('Seguir comprando', 'woocommerce'); ?></a>
            </div>
        </div>
    </div>
</aside>

<?php do_action('woocommerce_after_mini_cart'); ?>
<script>
    jQuery(function ($) {
        $('.close-cart').on('click', function () {
            $('.custom-floating-cart').toggleClass('hidden');
        });
    });
</script>