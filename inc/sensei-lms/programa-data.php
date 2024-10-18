<?php
/**
 * Obtiene los datos principales del programa educativo desde Sensei
 *
 * @param int $program_id ID del programa (curso o diplomado) en Sensei
 * @return array Datos del programa incluyendo nombre, número de estudiantes, lecciones y duración
 */
function get_sensei_program_data($program_id) {
    if (!$program_id || !class_exists('Sensei_Course')) {
        return array();
    }

    return array(
        'program_name' => get_the_title($program_id),
        'students_count' => Sensei()->course->course_completed_lessons_count($program_id),
        'lesson_count' => Sensei()->course->course_lesson_count($program_id),
        'modules' => get_program_modules($program_id),
        'program_duration' => get_program_duration($program_id),
    );
}