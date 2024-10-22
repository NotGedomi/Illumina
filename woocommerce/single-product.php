<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$program_data = get_program_data(118);

// Verificar si el array no está vacío
if (!empty($program_data)) {
    echo "<ul>";
    
    // Mostrar el nombre del programa y la modalidad
    echo "<li>Nombre del programa: {$program_data['program_name']}</li>";
    echo "<li>Modalidad: {$program_data['modality']}</li>";
    
    echo "</ul>";
} else {
    echo "El array está vacío.";
}