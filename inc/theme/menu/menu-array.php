<?php
// Función para obtener el array del menú con estructura de 3 niveles basado en su ubicación
function get_custom_menu_array($menu_location) {
    // Obtener las ubicaciones de los menús
    $locations = get_nav_menu_locations();

    // Verificar si la ubicación proporcionada existe
    if (!isset($locations[$menu_location])) {
        return []; // Retorna un array vacío si no existe la ubicación
    }

    // Obtener el ID del menú para la ubicación proporcionada
    $menu_id = $locations[$menu_location];

    // Obtener los elementos del menú
    $menu_items = wp_get_nav_menu_items($menu_id);
    if (!$menu_items) {
        return [];
    }

    // Inicializar el array jerárquico
    $menu_array = [];

    // Un mapa para agrupar los elementos del menú por su ID de padre
    $menu_items_by_parent = [];

    // Primer pase: agrupar los elementos por su ID de padre
    foreach ($menu_items as $item) {
        // Si no tiene un padre, se le asigna el valor 0 (nivel raíz)
        $parent_id = $item->menu_item_parent ? $item->menu_item_parent : 0;

        // Inicializar el array si no existe para ese ID de padre
        if (!isset($menu_items_by_parent[$parent_id])) {
            $menu_items_by_parent[$parent_id] = [];
        }

        // Guardar los detalles del elemento del menú
        $menu_items_by_parent[$parent_id][] = [
            'ID' => $item->ID,
            'title' => $item->title,
            'url' => $item->url,
            'children' => [] // Inicializar los hijos
        ];
    }

    // Función recursiva para construir el menú jerárquico
    $build_menu_tree = function($parent_id) use (&$menu_items_by_parent, &$build_menu_tree) {
        $menu_tree = [];

        // Verificar si hay elementos hijos para este ID de padre
        if (isset($menu_items_by_parent[$parent_id])) {
            foreach ($menu_items_by_parent[$parent_id] as $menu_item) {
                // Construir los submenús recursivamente
                $menu_item['children'] = $build_menu_tree($menu_item['ID']);
                $menu_tree[] = $menu_item;
            }
        }

        return $menu_tree;
    };

    // Iniciar la construcción del menú desde el nivel raíz (ID de padre 0)
    $menu_array = $build_menu_tree(0);

    return $menu_array;
}
