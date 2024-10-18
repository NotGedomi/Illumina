<?php
/**
 * Funciones para el login de usuarios
 */

/**
 * Realiza el login de un usuario
 * @param string $username Nombre de usuario o correo electrónico
 * @param string $password Contraseña
 * @param bool $remember Recordar usuario
 * @return true|WP_Error True si el login es exitoso, WP_Error en caso contrario
 */
function custom_login_user($username, $password, $remember = true) {
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    );

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        return $user;
    }

    // Si el usuario es un estudiante de Sensei, actualiza su última actividad
    if (class_exists('Sensei_Main') && user_can($user, 'read')) {
        Sensei_Utils::update_user_last_activity($user->ID);
    }

    return true;
}

/**
 * Verifica si el usuario tiene acceso a un curso específico de Sensei
 * @param int $user_id ID del usuario
 * @param int $course_id ID del curso
 * @return bool True si tiene acceso, false en caso contrario
 */
function user_has_course_access($user_id, $course_id) {
    if (!class_exists('Sensei_Main')) {
        return false;
    }

    return Sensei_Utils::user_started_course($course_id, $user_id);
}

/**
 * Obtiene los cursos en progreso del usuario
 * @param int $user_id ID del usuario
 * @return array Array de cursos en progreso
 */
function get_user_active_courses($user_id) {
    if (!class_exists('Sensei_Main')) {
        return array();
    }

    $args = array(
        'user_id' => $user_id,
        'status' => 'any',
        'type' => 'sensei_course_status'
    );

    $user_courses = Sensei_Utils::sensei_check_for_activity($args);

    $active_courses = array();
    foreach ($user_courses as $course) {
        $course_id = $course->comment_post_ID;
        $progress = Sensei()->course->get_completion_percentage($course_id, $user_id);
        $active_courses[] = array(
            'id' => $course_id,
            'title' => get_the_title($course_id),
            'progress' => $progress
        );
    }

    return $active_courses;
}