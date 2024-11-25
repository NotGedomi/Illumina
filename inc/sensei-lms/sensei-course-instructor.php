<?php
/**
 * Obtiene la información detallada del instructor del curso
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_instructor_info($course_id) {
    $instructor_id = get_post_field('post_author', $course_id);
    if (!$instructor_id) {
        return array();
    }

    $instructor = get_userdata($instructor_id);
    if (!$instructor) {
        return array();
    }

    // Obtener ID de la imagen de perfil
    $profile_image_id = get_user_meta($instructor->ID, 'instructor_profile_image_id', true);
    $profile_image_url = '';

    if ($profile_image_id) {
        $image_url = wp_get_attachment_image_url($profile_image_id, 'full');
        if ($image_url) {
            $profile_image_url = $image_url;
        }
    }

    // Si no hay imagen personalizada, intentar obtener el avatar
    if (empty($profile_image_url)) {
        $profile_image_url = get_avatar_url($instructor->ID, array('size' => 600));
    }

    return array(
        'instructor_name' => $instructor->display_name,
        'instructor_email' => $instructor->user_email,
        'instructor_id' => $instructor->ID,
        'instructor_bio' => get_user_meta($instructor->ID, 'description', true),
        'instructor_profile_image' => $profile_image_url,
        'instructor_facebook' => get_user_meta($instructor->ID, 'instructor_facebook', true),
        'instructor_linkedin' => get_user_meta($instructor->ID, 'instructor_linkedin', true),
        'instructor_instagram' => get_user_meta($instructor->ID, 'instructor_instagram', true)
    );
}