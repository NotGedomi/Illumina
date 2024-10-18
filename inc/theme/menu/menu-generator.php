<?php

/**
 * Muestra un menú de WordPress basado en su ubicación, convertido a una estructura de menú en HTML.
 *
 * @param string $menu_location La ubicación del menú en el tema de WordPress.
 * @param string $menu_name     El nombre del menú para usar en las clases CSS (por ejemplo, 'footer' o 'header').
 */

// Función para mostrar el menú en HTML
function display_custom_menu($menu_location, $menu_name)
{
    // Obtener el array del menú basado en la ubicación
    $menu_array = get_custom_menu_array($menu_location);

    // Función recursiva para mostrar el menú
    $display_menu_items = function ($menu_array, $level = 1, $menu_name) use (&$display_menu_items) {
        $current_level_class = $menu_name . '-level-' . $level;
        $container_class = ($level > 1) ? 'divider' : ''; // Clase para el div envolvente

        if ($level > 1) {
            ?>
            <div class="<?php echo esc_attr($container_class); ?>">
            <?php
        }

        ?>
            <ul class="<?php echo esc_attr($current_level_class); ?>">
                <?php
                foreach ($menu_array as $item) {
                    ?>
                    <li<?php echo ($level === 1 && !empty($item['children'])) ? ' class="has-submenu"' : ''; ?>>
                        <a href="<?php echo esc_url($item['url']); ?>">
                            <?php echo esc_html($item['title']); ?>
                        </a>

                        <?php if (!empty($item['children'])): ?>
                            <?php $display_menu_items($item['children'], $level + 1, $menu_name); // Mostrar submenú ?>
                        <?php endif; ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php

        if ($level > 1) {
            ?>
            </div>
            <?php
        }
    };

    // Mostrar el menú principal
    $display_menu_items($menu_array, 1, $menu_name);
}

?>
