<?php
/**
 * Obtiene posts similares basados en categorías compartidas
 * 
 * @param int $post_id ID del post actual
 * @param array $args Argumentos para personalizar la consulta
 * @return array Array de posts similares
 */
function get_similar_posts($post_id, $args = array()) {
    // Valores por defecto
    $defaults = array(
        'posts_per_page' => 3,     // Cantidad de posts similares
        'orderby' => 'rand',       // Orden aleatorio por defecto
        'exclude_current' => true   // Excluir post actual
    );

    // Combinar argumentos
    $args = wp_parse_args($args, $defaults);

    // Obtener categorías del post actual
    $categories = wp_get_post_categories($post_id, array('fields' => 'ids'));

    if (empty($categories)) {
        return array();
    }

    // Preparar argumentos para WP_Query
    $query_args = array(
        'category__in' => $categories,
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $args['posts_per_page'],
        'orderby' => $args['orderby']
    );

    // Excluir post actual si se especifica
    if ($args['exclude_current']) {
        $query_args['post__not_in'] = array($post_id);
    }

    // Realizar la consulta
    $query = new WP_Query($query_args);
    $similar_posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            // Obtener categorías del post similar
            $post_categories = get_the_category();
            $cats_array = array();
            foreach ($post_categories as $cat) {
                $cats_array[] = array(
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'url' => get_category_link($cat->term_id)
                );
            }

            // Construir array de datos del post
            $similar_posts[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'categories' => $cats_array,
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'date' => get_the_date('Y-m-d'),
                'excerpt' => get_the_excerpt()
            );
        }
        wp_reset_postdata();
    }

    return $similar_posts;
}