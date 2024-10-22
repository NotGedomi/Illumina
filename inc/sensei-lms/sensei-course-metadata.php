<?php
/**
 * Obtiene los metadatos personalizados del curso incluyendo traducciones
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_course_metadata($course_id) {
    $is_diplomado = has_term('diplomados', 'course-category', $course_id);

    // Mapeo de niveles con traducciones
    $level_translations = array(
        'introductory' => 'Introductorio',
        'intermediate' => 'Intermedio',
        'advanced' => 'Avanzado'
    );

    // Obtener nivel y traducirlo si existe
    $raw_level = get_post_meta($course_id, '_program_level', true);
    $translated_level = isset($level_translations[$raw_level]) ? $level_translations[$raw_level] : $raw_level;

    $metadata = array(
        'availability_date' => get_post_meta($course_id, '_program_availability_date', true),
        'level' => $translated_level,
        'raw_level' => $raw_level // mantener el valor original por si se necesita
    );

    // Mapeo de modalidades
    $modality_translations = array(
        'presencial' => 'Presencial',
        'semi_presencial' => 'Semi Presencial',
        'virtual' => 'Virtual'
    );

    if ($is_diplomado) {
        $raw_modality = get_post_meta($course_id, '_program_modality', true);
        $metadata['modality'] = isset($modality_translations[$raw_modality]) ? 
            $modality_translations[$raw_modality] : $raw_modality;
    } else {
        $metadata['credits'] = get_post_meta($course_id, '_program_credits', true);
    }

    return $metadata;
}