<?php
/**
 * Muestra un menú de WordPress basado en su ubicación, convertido a una estructura de menú en HTML.
 *
 * @param string $menu_location La ubicación del menú en el tema de WordPress.
 * @param string $menu_name    El nombre del menú para usar en las clases CSS.
 */
function display_custom_menu($menu_location, $menu_name)
{
    // Obtener el array del menú basado en la ubicación
    $menu_array = get_custom_menu_array($menu_location);

    // Función recursiva para mostrar el menú
    $display_menu_items = function ($menu_array, $level = 1, $menu_name, $parent = null) use (&$display_menu_items) {
        $current_level_class = $menu_name . '-level-' . $level;

        if ($level > 1) { ?>
            <div class="divider">
                <div class="submenu-container">
                <?php }

        ?>
                <ul class="<?php echo esc_attr($current_level_class); ?>">
                    <?php foreach ($menu_array as $item) {
                        $has_submenu = !empty($item['children']);
                        $item_class = $has_submenu ? ' class="has-submenu"' : '';

                        // Obtener datos de categoría de WooCommerce si aplica
                        $category_thumb = '';
                        $category_desc = '';
                        if (strpos($item['url'], '/product-category/') !== false) {
                            $category_slug = basename(rtrim($item['url'], '/'));
                            $category = get_term_by('slug', $category_slug, 'product_cat');
                            if ($category) {
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                if ($thumbnail_id) {
                                    $category_thumb = wp_get_attachment_url($thumbnail_id);
                                }
                                $category_desc = category_description($category->term_id);
                            }
                        }
                        ?>
                        <li<?php echo $item_class; ?>>
                            <?php if ($has_submenu) { ?>
                                <span>
                                    <div class="icon-cat">
                                        <?php if ($category_thumb) { ?>
                                            <img src="<?php echo esc_url($category_thumb); ?>" alt="<?php echo esc_attr($item['title']); ?>"
                                                class="category-thumb">
                                        <?php } ?>
                                    </div>
                                    <div class="info-cat">
                                        <?php echo esc_html($item['title']); ?>
                                        <?php if ($category_desc) { ?>
                                            <div class="category-description"><?php echo wp_kses_post($category_desc); ?></div>
                                        <?php } ?>
                                    </div>
                                </span>
                                <?php $display_menu_items($item['children'], $level + 1, $menu_name, $item); ?>
                            <?php } else { ?>
                                <a href="<?php echo esc_url($item['url']); ?>">
                                    <div class="icon-cat">
                                        <?php if ($category_thumb) { ?>
                                            <img src="<?php echo esc_url($category_thumb); ?>" alt="<?php echo esc_attr($item['title']); ?>"
                                                class="category-thumb">
                                        <?php } ?>
                                    </div>
                                    <div class="info-cat">
                                        <?php echo esc_html($item['title']); ?>
                                        <?php if ($category_desc) { ?>
                                            <div class="category-description"><?php echo wp_kses_post($category_desc); ?></div>
                                        <?php } ?>
                                    </div>

                                </a>
                            <?php } ?>
                            </li>
                        <?php } ?>
                </ul>

                <?php if ($level > 1) { ?>
                </div>
                <div class="cat-container">
                    <a class="purple-btn" href="<?php echo esc_url($parent['url']); ?>">
                        Ver más <?php echo esc_html($parent['title']); ?>
                    </a>
                </div>
            </div>
        <?php }
    };

    // Mostrar el menú principal
    $display_menu_items($menu_array, 1, $menu_name);
}
?>