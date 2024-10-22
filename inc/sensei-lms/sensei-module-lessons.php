<?php
/**
 * Obtiene las lecciones de un módulo específico.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_module_lessons($course_id, $module_id) {
    $lessons = array();
    
    if (class_exists('Sensei_Course_Structure')) {
        $course_structure = Sensei_Course_Structure::instance($course_id)->get('view', true);
        
        foreach ($course_structure as $item) {
            if ($item['type'] === 'module' && $item['id'] === $module_id) {
                foreach ($item['lessons'] as $lesson) {
                    $lessons[] = array(
                        'lesson_id' => $lesson['id'],
                        'lesson_name' => $lesson['title'],
                        'lesson_duration' => get_post_meta($lesson['id'], '_lesson_length', true)
                    );
                }
                break;
            }
        }
    }

    return $lessons;
}
