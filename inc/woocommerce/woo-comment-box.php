<?php
/**
 * Sistema de reseñas personalizado para WooCommerce
 * 
 * Implementa un sistema de calificación con estrellas SVG y validación de usuarios
 * para productos WooCommerce. Incluye estilos CSS anidados para mejor organización.
 *
 * @package TuTema
 * @subpackage WooCommerce
 */
 function custom_comment_box()
 {
     // Validaciones iniciales
     if (!comments_open() || !is_singular('product')) {
         return;
     }
 
     $producto_id = get_the_ID();
     $producto = wc_get_product($producto_id);
 
     if (!$producto) {
         return;
     }
 
     // Ocultar el formulario si el usuario no está logueado
     if (!is_user_logged_in()) {
         return;
     }
 
     // Ocultar el formulario si el usuario no compró el producto (si está habilitada la verificación)
     if (
         get_option('woocommerce_review_rating_verification_required') === 'yes' &&
         !wc_customer_bought_product('', get_current_user_id(), $producto_id)
     ) {
         return;
     }
 
     ob_start();
     ?>
 
     <div id="contenedor_formulario_comentario">
         <div id="formulario_comentario">
             <form id="formulario" class="formulario-comentario"
                 action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post">
                 <div class="main-comment">
                     <p class="calificacion-comentario">
                         <span class="estrellas">
                             <?php for ($i = 5; $i >= 1; $i--): ?>
                                 <input type="radio" id="estrella<?php echo esc_attr($i); ?>" name="rating"
                                     value="<?php echo esc_attr($i); ?>" required />
                                 <label for="estrella<?php echo esc_attr($i); ?>">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20"
                                         fill="none">
                                         <path
                                             d="M9.18806 1.52822C9.62584 0.824106 10.6506 0.824107 11.0884 1.52822L13.0843 4.73835C13.2383 4.98608 13.483 5.16386 13.7662 5.2338L17.436 6.14003C18.241 6.33881 18.5576 7.31343 18.0233 7.94737L15.587 10.8376C15.399 11.0606 15.3055 11.3483 15.3265 11.6392L15.5987 15.4094C15.6584 16.2364 14.8293 16.8388 14.0613 16.5264L10.5597 15.1026C10.2895 14.9927 9.987 14.9927 9.71677 15.1026L6.21519 16.5264C5.44715 16.8388 4.61808 16.2364 4.67777 15.4094L4.94992 11.6392C4.97092 11.3483 4.87746 11.0606 4.68944 10.8376L2.2532 7.94737C1.71883 7.31343 2.03551 6.33881 2.84044 6.14003L6.51022 5.2338C6.79343 5.16386 7.03812 4.98608 7.19215 4.73834L9.18806 1.52822Z" />
                                     </svg>
                                 </label>
                             <?php endfor; ?>
                         </span>
                     </p>
                     <p class="texto-comentario">
                         <textarea id="comment" name="comment" cols="45" rows="8" required placeholder="Escribir comentario"></textarea>
                     </p>
                 </div>
 
                 <p class="enviar-formulario">
                     <input name="submit" type="submit" id="submit" class="enviar"
                         value="<?php esc_attr_e('Enviar', 'tu-textdomain'); ?>" />
                     <?php comment_id_fields($producto_id); ?>
                     <?php wp_nonce_field('product-comment', 'product-comment-nonce'); ?>
                 </p>
             </form>
         </div>
     </div>
     <?php
     echo ob_get_clean();
 }
 