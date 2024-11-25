<?php
/**
 * Obtiene los comentarios de un post específico
 * 
 * @param int $post_id ID del post
 * @param array $args Argumentos para personalizar la consulta
 * @return array Array de comentarios
 */
function get_post_comments($post_id, $args = array()) {
    // Valores por defecto
    $defaults = array(
        'number' => 5,             // Cantidad de comentarios
        'status' => 'approve',     // Solo comentarios aprobados
        'order' => 'DESC'          // Orden descendente
    );

    // Combinar argumentos
    $args = wp_parse_args($args, $defaults);

    // Preparar argumentos para get_comments
    $comments_args = array(
        'post_id' => $post_id,
        'number' => $args['number'],
        'status' => $args['status'],
        'order' => $args['order']
    );

    // Obtener comentarios
    $comments = get_comments($comments_args);
    $comments_array = array();

    foreach ($comments as $comment) {
        $comments_array[] = array(
            'id' => $comment->comment_ID,
            'author' => array(
                'name' => $comment->comment_author,
                'url' => $comment->comment_author_url,
                'avatar' => get_avatar_url($comment->comment_author_email)
            ),
            'content' => $comment->comment_content,
            'date' => $comment->comment_date,
            'parent' => $comment->comment_parent
        );
    }

    return $comments_array;
}