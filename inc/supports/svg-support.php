<?php 
// Permitir la carga de archivos SVG
function permitir_svg_en_wordpress($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'permitir_svg_en_wordpress');

// Evitar la sanitización de archivos SVG
function evitar_sanitizacion_svg($file) {
    if ($file['type'] === 'image/svg+xml') {
        $file['meta'] = [];
    }
    return $file;
}
add_filter('wp_check_filetype_and_ext', 'evitar_sanitizacion_svg', 10, 2);