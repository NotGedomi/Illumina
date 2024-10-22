<?php
/**
 * Calcula el número total de certificaciones disponibles en el curso.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_certifications_count($course_id) {
    $course = get_post($course_id);
    if (!$course || $course->post_type !== 'course') {
        return 0;
    }

    $certificate_count = get_post_meta($course_id, '_course_certificate', true) ? 1 : 0;

    if (class_exists('Sensei_Course_Structure')) {
        $course_structure = Sensei_Course_Structure::instance($course_id)->get('edit');
        
        foreach ($course_structure as $item) {
            if ($item['type'] === 'module') {
                $module_certificate = get_term_meta($item['id'], '_module_certificate', true);
                if ($module_certificate) {
                    $certificate_count++;
                }
            } elseif ($item['type'] === 'lesson') {
                $lesson_certificate = get_post_meta($item['id'], '_lesson_certificate', true);
                if ($lesson_certificate) {
                    $certificate_count++;
                }
            }
        }
    }

    return $certificate_count;
}
