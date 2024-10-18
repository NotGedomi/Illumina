<?php
/**
 * Calcula la duración total del programa educativo
 *
 * @param int $program_id ID del programa en Sensei
 * @return string Duración total del programa en formato legible
 */
function get_program_duration($program_id) {
    $total_duration = 0;
    $lessons = Sensei()->course->course_lessons($program_id);
    foreach ($lessons as $lesson) {
        $lesson_duration = get_post_meta($lesson->ID, '_lesson_length', true);
        $total_duration += intval($lesson_duration);
    }

    if ($total_duration >= 60) {
        $hours = floor($total_duration / 60);
        $minutes = $total_duration % 60;
        return $hours . ' horas' . ($minutes > 0 ? ' y ' . $minutes . ' minutos' : '');
    }
    return $total_duration . ' minutos';
}