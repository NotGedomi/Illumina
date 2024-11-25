<?php
/**
 * Función para mostrar el rating de un producto de WooCommerce
 *
 * @package Illumina
 * @subpackage WooCommerce
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function illumina_display_product_rating($product_id = null) {
    // Si no se proporciona un ID de producto, intentamos obtener el producto global
    if (!$product_id) {
        global $product;
        if (!$product || !is_a($product, 'WC_Product')) {
            // Si no hay un producto global válido, intentamos obtener el ID de la consulta actual
            $product_id = get_queried_object_id();
        } else {
            $product_id = $product->get_id();
        }
    }

    // Asegurarse de que tenemos un ID de producto válido
    if (!$product_id) {
        return ''; // Retornar vacío si no hay un producto válido
    }

    // Obtener el objeto del producto
    $product = wc_get_product($product_id);

    if (!$product) {
        return ''; // Retornar vacío si no se puede obtener el producto
    }

    // Obtener el rating promedio y el conteo de ratings
    $average_rating = $product->get_average_rating();
    $rating_count = $product->get_rating_count();

    // Obtener el conteo de ratings por estrella
    $rating_counts = get_product_rating_counts($product_id);

    // Calcular el total de ratings
    $total_ratings = array_sum($rating_counts);

    // Si no hay ratings, podemos decidir no mostrar nada o mostrar un mensaje
    if ($total_ratings == 0) {
        return '<p>Este producto aún no tiene valoraciones.</p>';
    }

    // Función para generar estrellas SVG
    function generate_stars($filled) {
        $star_filled = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none">
            <path d="M9.18806 1.52822C9.62584 0.824106 10.6506 0.824107 11.0884 1.52822L13.0843 4.73835C13.2383 4.98608 13.483 5.16386 13.7662 5.2338L17.436 6.14003C18.241 6.33881 18.5576 7.31343 18.0233 7.94737L15.587 10.8376C15.399 11.0606 15.3055 11.3483 15.3265 11.6392L15.5987 15.4094C15.6584 16.2364 14.8293 16.8388 14.0613 16.5264L10.5597 15.1026C10.2895 14.9927 9.987 14.9927 9.71677 15.1026L6.21519 16.5264C5.44715 16.8388 4.61808 16.2364 4.67777 15.4094L4.94992 11.6392C4.97092 11.3483 4.87746 11.0606 4.68944 10.8376L2.2532 7.94737C1.71883 7.31343 2.03551 6.33881 2.84044 6.14003L6.51022 5.2338C6.79343 5.16386 7.03812 4.98608 7.19215 4.73834L9.18806 1.52822Z" fill="#E4AC5B"/>
        </svg>';
        $star_empty = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none">
            <path d="M9.18806 1.52822C9.62584 0.824106 10.6506 0.824107 11.0884 1.52822L13.0843 4.73835C13.2383 4.98608 13.483 5.16386 13.7662 5.2338L17.436 6.14003C18.241 6.33881 18.5576 7.31343 18.0233 7.94737L15.587 10.8376C15.399 11.0606 15.3055 11.3483 15.3265 11.6392L15.5987 15.4094C15.6584 16.2364 14.8293 16.8388 14.0613 16.5264L10.5597 15.1026C10.2895 14.9927 9.987 14.9927 9.71677 15.1026L6.21519 16.5264C5.44715 16.8388 4.61808 16.2364 4.67777 15.4094L4.94992 11.6392C4.97092 11.3483 4.87746 11.0606 4.68944 10.8376L2.2532 7.94737C1.71883 7.31343 2.03551 6.33881 2.84044 6.14003L6.51022 5.2338C6.79343 5.16386 7.03812 4.98608 7.19215 4.73834L9.18806 1.52822Z" fill="#969696"/>
        </svg>';
        
        return str_repeat($star_filled, $filled) . str_repeat($star_empty, 5 - $filled);
    }

    ob_start();
    ?>
    <div class="rating">
        <h3>Valoraciones del curso</h3>
        <div class="rating-info">
            <div class="left">
                <h4 id="average-rating"><?php echo number_format($average_rating, 1); ?></h4>
                <div class="stars">
                    <?php echo generate_stars(round($average_rating)); ?>
                </div>
                <h5>Rating del curso</h5>
            </div>
            <div class="right">
                <?php for ($i = 5; $i >= 1; $i--) : 
                    $count = isset($rating_counts[$i]) ? $rating_counts[$i] : 0;
                    $percentage = $total_ratings > 0 ? ($count / $total_ratings) * 100 : 0;
                ?>
                <div class="countbar">
                    <div class="progress">
                        <span class="bar" style="width: <?php echo $percentage; ?>%;"></span>
                    </div>
                    <div class="total-stars">
                        <?php echo generate_stars($i); ?>
                    </div>
                    <div class="percentage">
                        <span><?php echo round($percentage); ?>%</span>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}