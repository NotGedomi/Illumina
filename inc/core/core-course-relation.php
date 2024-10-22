<?php
/**
 * Maneja la relación entre productos de WooCommerce y cursos de Sensei.
 * Obtiene los datos básicos de la relación producto-curso.
 *
 * @package Illumina
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

function get_product_course_relation($product_id) {
    if (!$product_id) {
        return false;
    }

    $args = \Sensei_WC_Paid_Courses\Courses::get_product_courses_query_args((int) $product_id);
    $args['fields'] = 'ids';
    $course_ids = get_posts($args);

    if (empty($course_ids)) {
        return false;
    }

    $course_id = reset($course_ids);
    $course = get_post($course_id);

    if (!$course || $course->post_type !== 'course') {
        return false;
    }

    return array(
        'course_id' => $course_id,
        'course_name' => $course->post_title,
        'course_content' => $course->post_content
    );
}
