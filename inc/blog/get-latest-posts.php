<?php
/**
 * Obtiene los últimos posts del blog con parámetros personalizables
 * 
 * @param array $args Argumentos para personalizar la consulta
 * @return array Array de posts con sus datos
 */
function get_latest_posts($args = array()) {
    // Valores por defecto
    $defaults = array(
        'category_slug' => '',     // Slug de la categoría
        'posts_per_page' => 6,     // Cantidad de posts a mostrar
        'offset' => 0,             // Desde qué post empezar
        'orderby' => 'date',       // Ordenar por fecha
        'order' => 'DESC'          // Orden descendente
    );

    // Combinar argumentos con valores por defecto
    $args = wp_parse_args($args, $defaults);

    // Preparar argumentos para WP_Query
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $args['posts_per_page'],
        'offset' => $args['offset'],
        'orderby' => $args['orderby'],
        'order' => $args['order']
    );

    // Añadir categoría si se especifica
    if (!empty($args['category_slug'])) {
        $query_args['category_name'] = $args['category_slug'];
    }

    // Realizar la consulta
    $query = new WP_Query($query_args);
    $posts_array = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            // Obtener categorías
            $categories = get_the_category();
            $cats_array = array();
            foreach ($categories as $cat) {
                $cats_array[] = array(
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'url' => get_category_link($cat->term_id)
                );
            }

            // Obtener rating
            $rating_data = get_post_rating(get_the_ID());

            // Construir array de datos del post
            $posts_array[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'categories' => $cats_array,
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'date' => get_the_date('Y-m-d'),
                'author' => array(
                    'name' => get_the_author(),
                    'url' => get_author_posts_url(get_the_author_meta('ID')),
                    'avatar' => get_avatar_url(get_the_author_meta('ID'))
                ),
                'excerpt' => get_the_excerpt(),
                'rating' => $rating_data
            );
        }
        wp_reset_postdata();
    }

    return $posts_array;
}