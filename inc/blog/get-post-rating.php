<?php
/**
 * Funciones para manejar el sistema de calificación de posts
 */

/**
 * Obtiene el rating de un post
 * 
 * @param int $post_id ID del post
 * @return array Datos del rating
 */
function get_post_rating($post_id) {
    $total_rating = (float) get_post_meta($post_id, '_total_rating', true);
    $rating_count = (int) get_post_meta($post_id, '_rating_count', true);
    
    $average = $rating_count > 0 ? round($total_rating / $rating_count, 1) : 0;
    
    return array(
        'average' => $average,
        'count' => $rating_count,
        'total' => $total_rating
    );
}

/**
 * Añade o actualiza el rating de un post
 * 
 * @param int $post_id ID del post
 * @param float $rating Rating (1-5)
 * @param int $user_id ID del usuario (opcional)
 * @return bool|array False si falla, array con nuevo rating si tiene éxito
 */
function add_post_rating($post_id, $rating, $user_id = null) {
    // Validar rating
    if ($rating < 1 || $rating > 5) {
        return false;
    }
    
    // Si se proporciona user_id, verificar si ya votó
    if ($user_id) {
        $user_ratings = get_post_meta($post_id, '_user_ratings', true);
        if (!is_array($user_ratings)) {
            $user_ratings = array();
        }
        
        if (isset($user_ratings[$user_id])) {
            return false; // Usuario ya votó
        }
        
        $user_ratings[$user_id] = $rating;
        update_post_meta($post_id, '_user_ratings', $user_ratings);
    }
    
    // Actualizar totales
    $current_total = (float) get_post_meta($post_id, '_total_rating', true);
    $current_count = (int) get_post_meta($post_id, '_rating_count', true);
    
    $new_total = $current_total + $rating;
    $new_count = $current_count + 1;
    
    update_post_meta($post_id, '_total_rating', $new_total);
    update_post_meta($post_id, '_rating_count', $new_count);
    
    return array(
        'average' => round($new_total / $new_count, 1),
        'count' => $new_count,
        'total' => $new_total
    );
}

/**
 * Verifica si un usuario ya calificó un post
 * 
 * @param int $post_id ID del post
 * @param int $user_id ID del usuario
 * @return bool
 */
function has_user_rated($post_id, $user_id) {
    if (!$user_id) return false;
    
    $user_ratings = get_post_meta($post_id, '_user_ratings', true);
    if (!is_array($user_ratings)) return false;
    
    return isset($user_ratings[$user_id]);
}