<?php
/**
 * Función principal que recopila todos los datos del programa educativo
 *
 * @param int $product_id ID del producto asociado al programa
 * @return array Todos los datos del programa educativo
 */
function get_program_data_by_product_id($product_id) {
    $program_data = array(
        'program_id' => '',
        'program_name' => '',
        'students_count' => 0,
        'lesson_count' => 0,
        'modules_count' => 0,
        'modules' => array(),
        'instructors' => array(),
        'instructors_count' => 0,
        'product_price' => '',
        'sale_price' => '',
        'attributes' => array(),
        'average_rating' => '',
        'product_image' => '',
        'categories' => array(),
        'rating_counts' => array(),
        'program_duration' => ''
    );

    $product_data = get_program_product_data($product_id);
    $program_data = array_merge($program_data, $product_data);

    $program_data['attributes'] = get_program_attributes($product_id);

    $program_id = '';
    $product = wc_get_product($product_id);
    if ($product) {
        foreach ($product->get_meta_data() as $meta) {
            if ($meta->key === 'datos_del_programa') {
                $program_id = $meta->value;
                break;
            }
        }
    }

    if ($program_id) {
        $sensei_data = get_sensei_program_data($program_id);
        $program_data = array_merge($program_data, $sensei_data);

        $program_data['program_id'] = $program_id;
        $program_data['instructors'][] = get_program_instructor_info($program_id);
        $program_data['instructors_count'] = count($program_data['instructors']);
    }

    $ratings_data = get_program_ratings($product_id);
    $program_data = array_merge($program_data, $ratings_data);

    return $program_data;
}