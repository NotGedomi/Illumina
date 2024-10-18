<?php
/**
 * Obtiene la información del instructor del programa educativo
 *
 * @param int $program_id ID del programa en Sensei
 * @return array Información del instructor incluyendo nombre, email y redes sociales
 */
function get_program_instructor_info($program_id) {
    $instructor_id = get_post_field('post_author', $program_id);
    if (!$instructor_id) {
        return array();
    }

    $instructor = get_userdata($instructor_id);
    if (!$instructor) {
        return array();
    }

    return array(
        'instructor_name' => $instructor->display_name,
        'instructor_email' => $instructor->user_email,
        'instructor_id' => $instructor->ID,
        'instructor_profile_image' => get_user_meta($instructor->ID, 'instructor_profile_image', true),
        'instructor_facebook' => get_user_meta($instructor->ID, 'instructor_facebook', true),
        'instructor_linkedin' => get_user_meta($instructor->ID, 'instructor_linkedin', true),
        'instructor_instagram' => get_user_meta($instructor->ID, 'instructor_instagram', true)
    );
}