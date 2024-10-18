<?php
/** 
 * Illumina
 * @link 
 * @package WordPress
 * @subpackage Illumina
 * @since 1.0.0
 * @version 2.1.0
 */

/*---------- FUNCIONALIDADES DEL THEME EN GENERAL ----------*/

// Definir Rutas principales
define('URL', get_stylesheet_directory_uri());
define('ASSETS', URL . '/assets');

// Obtiene los archivos de los directorios CSS y JS
function get_theme_assets_paths()
{
    return [
        'CSS' => get_stylesheet_directory() . '/assets/css',
        'JS' => get_stylesheet_directory() . '/assets/js',
        'LIB_CSS' => get_stylesheet_directory() . '/assets/css/libraries',
        'LIB_JS' => get_stylesheet_directory() . '/assets/js/libraries',
    ];
}

// Función recursiva para obtener archivos en un directorio
function get_files($directory, $extension)
{
    $files = glob($directory . '/*' . $extension);
    $subdirs = glob($directory . '/*', GLOB_ONLYDIR);

    foreach ($subdirs as $subdir) {
        $files = array_merge($files, get_files($subdir, $extension));
    }

    return $files;
}

// Función para encolar los estilos
function enqueue_theme_styles()
{
    $paths = get_theme_assets_paths();
    $version = wp_get_theme()->get('Version');

    // Encolar CSS de 'libraries/css'
    foreach (get_files($paths['LIB_CSS'], '.css') as $file) {
        $handle = basename($file, '.css');
        $handle = str_replace(['.min', '-min'], '', $handle);
        wp_enqueue_style($handle, str_replace(get_stylesheet_directory(), URL, $file), [], $version);
    }

    // Encolar "styles.css" desde "assets/css"
    wp_enqueue_style('theme-style', ASSETS . '/css/styles.css', [], $version);

    // Encolar CSS restantes de 'assets/css'
    foreach (get_files($paths['CSS'], '.css') as $file) {
        if (basename($file) !== 'styles.css' && strpos($file, '/libraries/') === false) {
            $handle = 'theme-' . basename($file, '.css');
            $handle = str_replace(['.min', '-min'], '', $handle);
            wp_enqueue_style($handle, str_replace(get_stylesheet_directory(), URL, $file), [], $version);
        }
    }
}

// Función para encolar los scripts
function enqueue_theme_scripts()
{
    $paths = get_theme_assets_paths();
    $version = wp_get_theme()->get('Version');

    wp_enqueue_script('jquery');

    // Encolar los archivos JS de 'libraries/js'
    $library_handles = ['jquery'];
    foreach (get_files($paths['LIB_JS'], '.js') as $file) {
        $handle = basename($file, '.js');
        $handle = str_replace(['.min', '-min'], '', $handle);
        $library_handles[] = $handle;
        wp_enqueue_script($handle, str_replace(get_stylesheet_directory(), URL, $file), ['jquery'], $version, true);
    }

    // Encolar los archivos JS de la carpeta "extensions"
    foreach (get_files($paths['JS'] . '/extensions', '.js') as $file) {
        $handle = basename($file, '.js');
        $handle = str_replace(['.min', '-min'], '', $handle);
        wp_enqueue_script($handle, str_replace(get_stylesheet_directory(), URL, $file), $library_handles, $version, true);
    }

    // Encolar todos los archivos JS restantes desde "assets/js"
    foreach (get_files($paths['JS'], '.js') as $file) {
        if (strpos($file, '/libraries/') === false && strpos($file, '/extensions/') === false) {
            $handle = basename($file, '.js');
            $handle = str_replace(['.min', '-min'], '', $handle);
            wp_enqueue_script($handle, str_replace(get_stylesheet_directory(), URL, $file), $library_handles, $version, true);
        }
    }
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles');
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// Función para agregar soporte a características del tema
function theme_setup()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

// Función para establecer la longitud del extracto
function custom_excerpt_length($length)
{
    return apply_filters('custom_excerpt_length', 30);
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Registrar menus
function register_my_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Menu en el Header'),
        'footer-menu' => __('Menu en el Footer'),
    ));
}
add_action('init', 'register_my_menus');

// Require de archivos de INC (Automático y Recursivo)
function include_inc_files($dir) {
    $files = get_files($dir, '.php');
    foreach ($files as $file) {
        if (basename($file) !== 'index.php') {
            require_once $file;
        }
    }
}

include_inc_files(get_template_directory() . '/inc');