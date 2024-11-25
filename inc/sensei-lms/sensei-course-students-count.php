<?php
/**
 * Función para contar estudiantes de cursos de Sensei
 *
 * @package Sensei
 * @subpackage Students
 */

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente
}

/**
 * Obtiene el número de usuarios inscritos en un curso.
 *
 * @param int $course_id El ID del curso.
 * @return int El número de usuarios inscritos.
 */
function get_course_enrolled_users_count($course_id) {
    return Sensei_Utils::sensei_check_for_activity(
        array(
            'post_id' => $course_id,
            'type'    => 'sensei_course_status',
            'status'  => 'any',
        )
    );
}