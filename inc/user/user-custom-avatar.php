<?php
/**
 * Oculta el campo de imagen de perfil estándar de WordPress
 */
function remove_default_user_profile_fields($user) {
    ?>
    <style type="text/css">
        tr.user-profile-picture {
            display: none;
        }
    </style>
    <?php
}
add_action('show_user_profile', 'remove_default_user_profile_fields');
add_action('edit_user_profile', 'remove_default_user_profile_fields');

/**
 * Reemplaza la imagen de perfil de WordPress con nuestra imagen personalizada
 */
function custom_user_profile_image($avatar, $id_or_email, $size, $default, $alt) {
    $user = false;

    if (is_numeric($id_or_email)) {
        $id = (int) $id_or_email;
        $user = get_user_by('id', $id);
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by('id', $id);
        }
    } else {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user && is_object($user)) {
        $image_id = get_user_meta($user->ID, 'instructor_profile_image_id', true);
        if ($image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
            if ($image_url) {
                $avatar = "<img alt='{$alt}' src='{$image_url[0]}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
            }
        }
    }

    return $avatar;
}
add_filter('get_avatar', 'custom_user_profile_image', 1, 5);