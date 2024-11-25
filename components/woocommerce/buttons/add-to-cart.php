<?php
/**
 * Botón de agregar al carrito
 * 
 * @package Illumina
 * @subpackage Components
 * @var array $button_product Datos del producto para el botón
 */

if (!defined('ABSPATH')) {
    exit;
}

// Obtener el ID del producto
$product_id = isset($button_product['id']) ? $button_product['id'] : 0;
if (!$product_id) {
    return;
}

// Usar la función existente para obtener el estado del botón
$button_state = get_product_button_state($product_id);

// Preparar clases y atributos del botón
$button_class = 'add-to-cart-btn';
$button_text = 'Agregar';
$disabled = '';
$data_attrs = array(
    'product_id' => $product_id,
    'state' => 'default'
);

// Establecer estado del botón basado en la función existente
if ($button_state['already_bought']) {
    $button_class .= ' disabled already-bought';
    $button_text = 'Ya adquirido';
    $disabled = 'disabled';
    $data_attrs['state'] = 'bought';
} elseif ($button_state['in_cart']) {
    $button_class .= ' in-cart';
    $button_text = 'Añadido';
    $disabled = 'disabled';
    $data_attrs['state'] = 'in_cart';
} elseif (!$button_state['is_in_stock']) {
    $button_class .= ' out-of-stock disabled';
    $button_text = 'Agotado';
    $disabled = 'disabled';
    $data_attrs['state'] = 'out_of_stock';
}

// Construir atributos data
$data_attributes = '';
foreach ($data_attrs as $key => $value) {
    $data_attributes .= ' data-' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<button 
    class="<?php echo esc_attr($button_class); ?>"
    <?php echo $data_attributes; ?>
    <?php echo $disabled; ?>>
    <span><?php echo esc_html($button_text); ?></span>
</button>

<?php if ($button_state['already_bought'] && !empty($button_state['course_data'])): ?>
    <a href="<?php echo esc_url(get_permalink($button_state['course_data']['course_id'])); ?>" 
       class="view-course-link">
        Ver curso
    </a>
<?php endif; ?>