<?php
/**
 * Obtiene la lista de módulos del curso.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_modules($course_id) {
    $modules = array();
    
    if (class_exists('Sensei_Course_Structure')) {
        $course_structure = Sensei_Course_Structure::instance($course_id)->get('view', true);
        
        foreach ($course_structure as $item) {
            if ($item['type'] === 'module') {
                $modules[] = array(
                    'module_id' => $item['id'],
                    'module_name' => $item['title']
                );
            }
        }
    }

    return $modules;
}
