<?php
/**
 * Maneja el campo de icono para las categorías de cursos usando el Media Uploader
 * 
 * @package Illumina
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Encolar scripts necesarios
function enqueue_media_uploader() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

// Añadir campo de icono en el formulario de nueva categoría
function add_category_icon_field() {
    ?>
    <div class="form-field">
        <label for="category_icon">Icono de la Categoría</label>
        <div id="category-icon-wrapper">
            <input type="hidden" name="category_icon" id="category_icon" value="" />
            <div id="category-icon-preview"></div>
            <input type="button" class="button button-secondary" id="upload_icon_button" value="Seleccionar Icono" />
            <input type="button" class="button button-secondary hidden" id="remove_icon_button" value="Eliminar Icono" />
        </div>
        <p>Seleccione una imagen para usar como icono de esta categoría</p>
    </div>
    <?php
    add_media_upload_scripts();
}
add_action('course-category_add_form_fields', 'add_category_icon_field');

// Añadir campo de icono en el formulario de edición
function edit_category_icon_field($term) {
    $icon_id = get_term_meta($term->term_id, 'category_icon', true);
    $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_icon">Icono de la Categoría</label></th>
        <td>
            <div id="category-icon-wrapper">
                <input type="hidden" name="category_icon" id="category_icon" value="<?php echo esc_attr($icon_id); ?>" />
                <div id="category-icon-preview">
                    <?php if ($icon_url): ?>
                        <img src="<?php echo esc_url($icon_url); ?>" style="max-width: 100px; height: auto;" />
                    <?php endif; ?>
                </div>
                <input type="button" class="button button-secondary" id="upload_icon_button" value="<?php echo $icon_id ? 'Cambiar Icono' : 'Seleccionar Icono'; ?>" />
                <?php if ($icon_id): ?>
                    <input type="button" class="button button-secondary" id="remove_icon_button" value="Eliminar Icono" />
                <?php endif; ?>
            </div>
            <p class="description">Seleccione una imagen para usar como icono de esta categoría</p>
        </td>
    </tr>
    <?php
    add_media_upload_scripts();
}
add_action('course-category_edit_form_fields', 'edit_category_icon_field');

// Añadir scripts necesarios para el media uploader
function add_media_upload_scripts() {
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    ?>
    <style>
        #category-icon-preview img {
            margin: 10px 0;
            max-width: 100px;
            height: auto;
        }
        #category-icon-wrapper .hidden {
            display: none;
        }
    </style>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('#upload_icon_button').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var frame = wp.media({
                    title: 'Seleccionar Icono de Categoría',
                    button: {
                        text: 'Usar como icono'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    var imageUrl = attachment.url;  // URL por defecto
                    
                    // Intentar obtener el tamaño thumbnail si existe
                    if (attachment.sizes && attachment.sizes.thumbnail) {
                        imageUrl = attachment.sizes.thumbnail.url;
                    }
                    
                    $('#category_icon').val(attachment.id);
                    $('#category-icon-preview').html('<img src="' + imageUrl + '" />');
                    button.val('Cambiar Icono');
                    $('#remove_icon_button').removeClass('hidden').show();
                });

                frame.open();
            });

            $('#remove_icon_button').on('click', function(e) {
                e.preventDefault();
                $('#category_icon').val('');
                $('#category-icon-preview').empty();
                $('#upload_icon_button').val('Seleccionar Icono');
                $(this).hide();
            });
        }
    });
    </script>
    <?php
}

// Guardar el campo de icono
function save_category_icon($term_id) {
    if (isset($_POST['category_icon'])) {
        update_term_meta($term_id, 'category_icon', absint($_POST['category_icon']));
    }
}
add_action('created_course-category', 'save_category_icon');
add_action('edited_course-category', 'save_category_icon');

// Obtener el icono de una categoría
function get_course_category_icon($term_id) {
    $icon_id = get_term_meta($term_id, 'category_icon', true);
    return $icon_id ? wp_get_attachment_url($icon_id) : '';
}

// Obtener el ID del icono de una categoría
function get_course_category_icon_id($term_id) {
    return get_term_meta($term_id, 'category_icon', true);
}