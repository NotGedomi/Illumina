<?php
/**
 * Calcula la información de duración del curso.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_duration_info($course_id) {
    $total_minutes = 0;
    
    if (class_exists('Sensei_Course_Structure')) {
        $course_structure = Sensei_Course_Structure::instance($course_id)->get('edit');
        
        foreach ($course_structure as $item) {
            if ($item['type'] === 'module') {
                foreach ($item['lessons'] as $lesson) {
                    $lesson_duration = get_post_meta($lesson['id'], '_lesson_length', true);
                    $total_minutes += intval($lesson_duration);
                }
            } elseif ($item['type'] === 'lesson') {
                $lesson_duration = get_post_meta($item['id'], '_lesson_length', true);
                $total_minutes += intval($lesson_duration);
            }
        }
    }

    $hours = floor($total_minutes / 60);
    $minutes = $total_minutes % 60;
    $weeks = ceil($hours / 40);
    $months = ceil($weeks / 4);

    return array(
        'total_minutes' => $total_minutes,
        'hours' => $hours,
        'minutes' => $minutes,
        'weeks' => $weeks,
        'months' => $months,
        'formatted_duration' => $hours . ' horas' . ($minutes > 0 ? ' y ' . $minutes . ' minutos' : ''),
        'estimated_duration' => $months > 1 ? $months . ' meses' : $weeks . ' semanas'
    );
}
