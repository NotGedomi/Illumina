<?php
/**
 * Obtiene la estructura de módulos y lecciones del programa educativo
 *
 * @param int $program_id ID del programa en Sensei
 * @return array Estructura de módulos y lecciones del programa
 */
function get_program_modules($program_id) {
    if (!class_exists('Sensei_Course_Structure')) {
        return array();
    }

    $program_structure = Sensei_Course_Structure::instance($program_id)->get('view', true);
    $modules = array();
    foreach ($program_structure as $item) {
        if ($item['type'] === 'module') {
            $modules[] = array(
                'module_name' => $item['title'],
                'lessons' => array_map(function($lesson) {
                    return $lesson['title'];
                }, $item['lessons']),
                'lessons_count' => count($item['lessons'])
            );
        }
    }
    return $modules;
}