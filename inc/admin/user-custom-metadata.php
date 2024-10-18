<?php
/**
 * Añade campos personalizados al perfil de usuario
 *
 * @param WP_User $user Objeto de usuario actual
 */
function add_custom_user_fields($user) {
    ?>
    <h3>Información adicional del instructor</h3>
    <table class="form-table">
        <tr>
            <th><label for="instructor_profile_image">URL de imagen de perfil</label></th>
            <td>
                <input type="text" name="instructor_profile_image" id="instructor_profile_image" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_profile_image', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instructor_facebook">Facebook</label></th>
            <td>
                <input type="text" name="instructor_facebook" id="instructor_facebook" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_facebook', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instructor_linkedin">LinkedIn</label></th>
            <td>
                <input type="text" name="instructor_linkedin" id="instructor_linkedin" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_linkedin', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="instructor_instagram">Instagram</label></th>
            <td>
                <input type="text" name="instructor_instagram" id="instructor_instagram" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'instructor_instagram', true)); ?>" 
                       class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Guarda los campos personalizados del perfil de usuario
 *
 * @param int $user_id ID del usuario
 * @return bool|void
 */
function save_custom_user_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'instructor_profile_image', sanitize_text_field($_POST['instructor_profile_image']));
    update_user_meta($user_id, 'instructor_facebook', sanitize_text_field($_POST['instructor_facebook']));
    update_user_meta($user_id, 'instructor_linkedin', sanitize_text_field($_POST['instructor_linkedin']));
    update_user_meta($user_id, 'instructor_instagram', sanitize_text_field($_POST['instructor_instagram']));
}

// Añadir campos al formulario de perfil
add_action('show_user_profile', 'add_custom_user_fields');
add_action('edit_user_profile', 'add_custom_user_fields');

// Guardar los campos personalizados
add_action('personal_options_update', 'save_custom_user_fields');
add_action('edit_user_profile_update', 'save_custom_user_fields');