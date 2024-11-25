<?php
/**
 * Calcula el tiempo de lectura de un post
 * 
 * @param int $post_id ID del post
 * @param int $wpm Palabras por minuto (opcional)
 * @return array Información del tiempo de lectura
 */
function get_reading_time($post_id, $wpm = 200) {
    // Obtener el contenido del post
    $content = get_post_field('post_content', $post_id);
    
    // Limpiar el contenido
    $content = strip_shortcodes($content);
    $content = strip_tags($content);
    
    // Contar palabras
    $word_count = str_word_count($content);
    
    // Calcular minutos
    $minutes = ceil($word_count / $wpm);
    
    return array(
        'minutes' => $minutes,
        'word_count' => $word_count,
        'text' => sprintf(
            _n(
                '%d minuto de lectura',
                '%d minutos de lectura',
                $minutes,
                'text-domain'
            ),
            $minutes
        )
    );
}