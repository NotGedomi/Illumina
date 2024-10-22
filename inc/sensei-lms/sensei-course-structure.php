<?php
/**
 * Obtiene la estructura completa del curso usando las funciones nativas de Sensei
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_structure($course_id) {
    $structure = array(
        'modules' => array(),
        'modules_count' => 0,
        'lessons' => array(),
        'lesson_count' => 0
    );

    if (!class_exists('Sensei_Course')) {
        return $structure;
    }

    // Obtener módulos del curso usando el método nativo de Sensei
    $course_modules = Sensei()->modules->get_course_modules($course_id);

    if (!is_wp_error($course_modules) && !empty($course_modules)) {
        $structure['modules_count'] = count($course_modules);

        foreach ($course_modules as $module) {
            // Obtener lecciones del módulo usando el método nativo de Sensei
            $module_lessons = Sensei()->modules->get_lessons($course_id, $module->term_id);
            
            $module_data = array(
                'module_name' => $module->name,
                'module_id' => $module->term_id,
                'module_description' => $module->description,
                'lessons' => array(),
                'lessons_count' => 0
            );

            if (!empty($module_lessons)) {
                foreach ($module_lessons as $lesson) {
                    $module_data['lessons'][] = array(
                        'lesson_name' => $lesson->post_title,
                        'lesson_id' => $lesson->ID,
                        'lesson_duration' => get_post_meta($lesson->ID, '_lesson_length', true)
                    );
                    $module_data['lessons_count']++;
                    $structure['lesson_count']++;
                }
            }

            $structure['modules'][] = $module_data;
        }
    }

    // Obtener lecciones que no están en módulos
    $args = array(
        'post_type' => 'lesson',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_lesson_course',
                'value' => intval($course_id)
            )
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'module',
                'operator' => 'NOT EXISTS'
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );

    $independent_lessons = get_posts($args);

    if (!empty($independent_lessons)) {
        foreach ($independent_lessons as $lesson) {
            $structure['lessons'][] = array(
                'lesson_name' => $lesson->post_title,
                'lesson_id' => $lesson->ID,
                'lesson_duration' => get_post_meta($lesson->ID, '_lesson_length', true)
            );
            $structure['lesson_count']++;
        }
    }

    if (WP_DEBUG) {
        error_log('Course Structure: ' . print_r($structure, true));
    }

    return $structure;
}