<?php
/**
 * Maneja los metadatos personalizados del usuario
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Añade campos personalizados al perfil de usuario
 */
function add_custom_user_fields($user) {
    wp_enqueue_media();
    ?>
    <h3>Información adicional del instructor</h3>
    <table class="form-table">
        <tr>
            <th><label for="instructor_profile_image">Imagen de perfil</label></th>
            <td>
                <?php
                $image_id = get_user_meta($user->ID, 'instructor_profile_image_id', true);
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
                ?>
                <div class="instructor-image-preview">
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; height: auto; <?php echo $image_url ? '' : 'display: none;'; ?>">
                </div>
                <input type="hidden" name="instructor_profile_image_id" id="instructor_profile_image_id" value="<?php echo esc_attr($image_id); ?>">
                <button type="button" class="button" id="upload_profile_image_button">Subir imagen</button>
                <button type="button" class="button" id="remove_profile_image_button" <?php echo $image_url ? '' : 'style="display: none;"'; ?>>Eliminar imagen</button>
                <p class="description">Sube o elige una imagen para tu perfil. Se recomienda una imagen de al menos 300x300 píxeles.</p>
            </td>
        </tr>
        <tr>
            <th><label for="instructor_facebook">Facebook</label></th>
            <td>
                <input type="url" name="instructor_facebook" id="instructor_facebook" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_facebook', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instructor_linkedin">LinkedIn</label></th>
            <td>
                <input type="url" name="instructor_linkedin" id="instructor_linkedin" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_linkedin', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instructor_instagram">Instagram</label></th>
            <td>
                <input type="url" name="instructor_instagram" id="instructor_instagram" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_instagram', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
    </table>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var file_frame;
        var wp_media_post_id = wp.media.model.settings.post.id;
        var set_to_post_id = <?php echo $user->ID; ?>;

        $('#upload_profile_image_button').on('click', function(event) {
            event.preventDefault();

            if (file_frame) {
                file_frame.uploader.uploader.param('post_id', set_to_post_id);
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Seleccionar imagen de perfil',
                button: {
                    text: 'Usar esta imagen'
                },
                multiple: false
            });

            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#instructor_profile_image_id').val(attachment.id);
                $('.instructor-image-preview img').attr('src', attachment.url).show();
                $('#remove_profile_image_button').show();
            });

            file_frame.open();
        });

        $('#remove_profile_image_button').on('click', function(event) {
            event.preventDefault();
            $('#instructor_profile_image_id').val('');
            $('.instructor-image-preview img').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Guarda los campos personalizados del perfil de usuario
 */
function save_custom_user_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['instructor_profile_image_id'])) {
        update_user_meta($user_id, 'instructor_profile_image_id', absint($_POST['instructor_profile_image_id']));
    }

    if (isset($_POST['instructor_facebook'])) {
        update_user_meta($user_id, 'instructor_facebook', esc_url_raw($_POST['instructor_facebook']));
    }

    if (isset($_POST['instructor_linkedin'])) {
        update_user_meta($user_id, 'instructor_linkedin', esc_url_raw($_POST['instructor_linkedin']));
    }

    if (isset($_POST['instructor_instagram'])) {
        update_user_meta($user_id, 'instructor_instagram', esc_url_raw($_POST['instructor_instagram']));
    }
}

// Añadir campos al formulario de perfil
add_action('show_user_profile', 'add_custom_user_fields');
add_action('edit_user_profile', 'add_custom_user_fields');

// Guardar los campos personalizados
add_action('personal_options_update', 'save_custom_user_fields');
add_action('edit_user_profile_update', 'save_custom_user_fields');