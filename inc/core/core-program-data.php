<?php
/**
 * Función principal que coordina la obtención de todos los datos del programa educativo
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_program_data($product_id) {
    $program_data = array(
        'program_id' => '',
        'program_name' => '',
        'program_description' => '',
        'students_count' => 0,
        'lesson_count' => 0,
        'modules_count' => 0,
        'modules' => array(),
        'lessons' => array(),
        'instructors' => array(),
        'instructors_count' => 0,
        'product_price' => '',
        'sale_price' => '',
        'product_image' => '',
        'categories' => array(),
        'attributes' => array(),
        'average_rating' => 0,
        'rating_counts' => array(
            1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0
        ),
        'total_reviews' => 0,
        'program_duration' => '',
        'availability_date' => '',
        'level' => '',
        'modality' => '',
        'credits' => '',
        'certifications_count' => 0,
        'hours_academic' => 0,
        'estimated_duration' => ''
    );

    // Obtener relación producto-curso
    $product_course_data = get_product_course_relation($product_id);
    if (!$product_course_data || empty($product_course_data['course_id'])) {
        return $program_data;
    }

    $course_id = $product_course_data['course_id'];
    
    // Datos básicos
    $program_data['program_id'] = $course_id;
    $program_data['program_name'] = $product_course_data['course_name'];
    $program_data['program_description'] = $product_course_data['course_content'];

    // Datos del producto
    $product_data = get_product_data($product_id);
    $program_data = array_merge($program_data, $product_data);
    $program_data['product_image'] = get_product_image($product_id);
    $program_data['attributes'] = get_product_attributes($product_id);

    // Datos de valoraciones
    $program_data['rating_counts'] = get_product_rating_counts($product_id);
    $program_data['average_rating'] = get_product_average_rating($product_id);
    $program_data['total_reviews'] = array_sum($program_data['rating_counts']);

    // Estructura del curso (módulos y lecciones)
    $course_structure = get_course_structure($course_id);
    if (!empty($course_structure)) {
        $program_data['modules'] = $course_structure['modules'];
        $program_data['modules_count'] = $course_structure['modules_count'];
        $program_data['lessons'] = $course_structure['lessons'];
        $program_data['lesson_count'] = $course_structure['lesson_count'];
    }

    // Instructor
    $instructor_info = get_course_instructor_info($course_id);
    if ($instructor_info) {
        $program_data['instructors'][] = $instructor_info;
        $program_data['instructors_count'] = 1;
    }

    // Metadatos del curso
    $metadata = get_course_metadata($course_id);
    if ($metadata) {
        $program_data['level'] = $metadata['level'];
        $program_data['availability_date'] = $metadata['availability_date'];
        if (isset($metadata['modality'])) {
            $program_data['modality'] = $metadata['modality'];
        }
        if (isset($metadata['credits'])) {
            $program_data['credits'] = $metadata['credits'];
        }
    }

    // Duración
    $duration_info = get_course_duration_info($course_id);
    if ($duration_info) {
        $program_data['program_duration'] = $duration_info['formatted_duration'];
        $program_data['hours_academic'] = $duration_info['hours'];
        $program_data['estimated_duration'] = $duration_info['estimated_duration'];
    }

    // Certificaciones
    $program_data['certifications_count'] = get_course_certifications_count($course_id);

    return $program_data;
}