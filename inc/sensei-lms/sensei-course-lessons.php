<?php
/**
 * Obtiene todas las lecciones del curso, incluyendo las que están en módulos
 * y las independientes.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_lessons($course_id) {
    $lessons = array();
    
    if (class_exists('Sensei_Course_Structure')) {
        $course_structure = Sensei_Course_Structure::instance($course_id)->get('view', true);
        
        foreach ($course_structure as $item) {
            if ($item['type'] === 'module') {
                foreach ($item['lessons'] as $lesson) {
                    $lessons[] = array(
                        'lesson_id' => $lesson['id'],
                        'lesson_name' => $lesson['title'],
                        'module_id' => $item['id'],
                        'module_name' => $item['title'],
                        'lesson_duration' => get_post_meta($lesson['id'], '_lesson_length', true)
                    );
                }
            } elseif ($item['type'] === 'lesson') {
                $lessons[] = array(
                    'lesson_id' => $item['id'],
                    'lesson_name' => $item['title'],
                    'module_id' => 0,
                    'module_name' => '',
                    'lesson_duration' => get_post_meta($item['id'], '_lesson_length', true)
                );
            }
        }
    }

    return $lessons;
}
