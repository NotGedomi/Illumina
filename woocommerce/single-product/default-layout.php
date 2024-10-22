<?php
/**
 * Default Single Product layout
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/default-layout.php.
 *
 * @package Illumina
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$program_data = get_program_data(108);

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