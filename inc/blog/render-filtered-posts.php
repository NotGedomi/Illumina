<?php
/**
 * Funciones para manejar el filtrado y renderizado de posts del blog
 */

// Define el número de posts por página
defined('POSTS_PER_PAGE') or define('POSTS_PER_PAGE', 1);

/**
 * Renderiza los posts del blog con el formato especificado
 * 
 * @param array $posts Array de posts a renderizar
 * @param int $current_page Número de página actual
 * @param int $total_posts Total de posts para la paginación
 * @param bool $echo Si es true imprime el HTML, si es false lo retorna
 * @return string|void HTML generado si $echo es false
 */
function render_blog_posts($posts, $current_page = 1, $total_posts = 0, $echo = true) {
    ob_start();

    if (!empty($posts)) :
        foreach ($posts as $post) : ?>
            <div class="post-container">
                <div class="blog-card">
                    <div class="container">
                        <div class="img-preview">
                            <?php if ($post['image']) : ?>
                                <img src="<?php echo $post['image']; ?>" alt="">
                            <?php else : ?>
                                <img src="<?php echo ASSETS ?>/img/blog/demo-view.jfif" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="single-category">
                            <?php if (!empty($post['categories'])) : ?>
                                <span class="post-category"><?php echo $post['categories'][0]['name']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h3><?php echo $post['title']; ?></h3>
                            <p><?php echo $post['excerpt']; ?></p>
                        </div>
                        <div class="info">
                            <div class="right">
                                <div class="view-more">
                                    <a href="<?php echo $post['permalink']; ?>">Leer más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;
    else :
        echo '<p>No hay entradas disponibles.</p>';
    endif;

    $content = ob_get_clean();
    
    if ($echo) {
        echo $content;
    }
    
    return $content;
}

/**
 * Renderiza la paginación del blog
 * 
 * @param int $total_posts Total de posts
 * @param int $current_page Página actual
 * @param bool $echo Si es true imprime el HTML, si es false lo retorna
 * @return string|void HTML de la paginación si $echo es false
 */
function render_blog_pagination($total_posts, $current_page = 1, $echo = true) {
    ob_start();
    
    $max_pages = ceil($total_posts / POSTS_PER_PAGE);
    
    if ($max_pages > 1) {
        echo '<div class="pagination">';
        echo paginate_links(array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'total' => $max_pages,
            'current' => $current_page,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;'
        ));
        echo '</div>';
    }

    $content = ob_get_clean();
    
    if ($echo) {
        echo $content;
    }
    
    return $content;
}

/**
 * Obtiene y renderiza posts filtrados por categoría
 * 
 * @param array $categories IDs de categorías para filtrar
 * @param string $search Término de búsqueda
 * @param int $paged Número de página actual
 * @param bool $echo Si es true imprime el HTML, si es false lo retorna
 * @return string|void HTML generado si $echo es false
 */
function get_filtered_blog_posts($categories = [], $search = '', $paged = 1, $echo = true) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => POSTS_PER_PAGE,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged
    );

    if (!empty($categories)) {
        $args['cat'] = implode(',', $categories);
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $posts = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_category();
            $cats_array = [];

            foreach ($categories as $cat) {
                $cats_array[] = [
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                ];
            }

            $posts[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'excerpt' => get_the_excerpt(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'categories' => $cats_array
            ];
        }
        wp_reset_postdata();
    }

    $total_posts = $query->found_posts;
    
    if ($echo) {
        echo '<div class="blog-content-wrapper">';
        echo render_blog_posts($posts, $paged, $total_posts, false);
        echo '</div>';
        render_blog_pagination($total_posts, $paged, true);
    } else {
        return [
            'posts' => render_blog_posts($posts, $paged, $total_posts, false),
            'pagination' => render_blog_pagination($total_posts, $paged, false)
        ];
    }
}

/**
 * Manejador de Ajax para el filtrado de posts
 */
function ajax_filter_blog_posts() {
    $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    
    $result = get_filtered_blog_posts($categories, $search, $paged, false);
    echo json_encode($result);
    die();
}

// Registrar handlers de Ajax
add_action('wp_ajax_filter_blog_posts', 'ajax_filter_blog_posts');
add_action('wp_ajax_nopriv_filter_blog_posts', 'ajax_filter_blog_posts');