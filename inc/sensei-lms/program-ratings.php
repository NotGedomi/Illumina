<?php
/**
 * Obtiene las valoraciones y reseñas del programa educativo
 *
 * @param int $product_id ID del producto asociado al programa
 * @return array Datos de valoraciones incluyendo promedio, conteo por estrellas y total de reseñas
 */
function get_program_ratings($product_id) {
    $rating_counts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
    $total_rating = 0;
    $total_reviews = 0;

    $reviews = get_comments(array(
        'post_id' => $product_id,
        'status' => 'approve',
        'type' => 'review'
    ));

    foreach ($reviews as $review) {
        $rating = intval(get_comment_meta($review->comment_ID, 'rating', true));
        if ($rating >= 1 && $rating <= 5) {
            $rating_counts[$rating]++;
            $total_rating += $rating;
            $total_reviews++;
        }
    }

    $average_rating = $total_reviews > 0 ? $total_rating / $total_reviews : 0;

    return array(
        'average_rating' => round($average_rating, 1),
        'rating_counts' => $rating_counts,
        'total_reviews' => $total_reviews
    );
}