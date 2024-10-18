<?php
/**
 * Illumina Theme Settings
 *
 * @package Illumina
 */

// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Crear página de ajustes de Illumina
function illumina_admin_menu() {
    add_theme_page(
        'Ajustes de Illumina',
        'Illumina',
        'manage_options',
        'illumina-settings',
        'illumina_settings_page'
    );
}
add_action('admin_menu', 'illumina_admin_menu');

// Mostrar página de ajustes
function illumina_settings_page() {
    ?>
    <div class="wrap illumina-settings">
        <h1>Ajustes Generales de Illumina</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('illumina_settings_group');
            do_settings_sections('illumina-settings');
            submit_button('Guardar Ajustes');
            ?>
        </form>
    </div>
    <?php
}

// Registrar ajustes
function illumina_register_settings() {
    register_setting('illumina_settings_group', 'illumina_facebook');
    register_setting('illumina_settings_group', 'illumina_twitter');
    register_setting('illumina_settings_group', 'illumina_instagram');
    register_setting('illumina_settings_group', 'illumina_linkedin');
    register_setting('illumina_settings_group', 'illumina_phone_1');
    register_setting('illumina_settings_group', 'illumina_phone_2');
    register_setting('illumina_settings_group', 'illumina_footer_logo');
    register_setting('illumina_settings_group', 'illumina_header_logo');
    register_setting('illumina_settings_group', 'illumina_address');
    register_setting('illumina_settings_group', 'illumina_email');
    register_setting('illumina_settings_group', 'illumina_google_maps');

    add_settings_section('illumina_main_section', 'Información General', null, 'illumina-settings');

    add_settings_field('illumina_facebook', 'URL de Facebook', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_facebook', 'placeholder' => 'https://facebook.com/tu-pagina']);
    add_settings_field('illumina_twitter', 'URL de Twitter', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_twitter', 'placeholder' => 'https://twitter.com/tu-perfil']);
    add_settings_field('illumina_instagram', 'URL de Instagram', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_instagram', 'placeholder' => 'https://instagram.com/tu-perfil']);
    add_settings_field('illumina_linkedin', 'URL de LinkedIn', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_linkedin', 'placeholder' => 'https://linkedin.com/tu-perfil']);
    add_settings_field('illumina_phone_1', 'Teléfono Principal', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_phone_1', 'placeholder' => '(+51) 123 456 789']);
    add_settings_field('illumina_phone_2', 'Teléfono Secundario', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_phone_2', 'placeholder' => '(+51) 123 456 789']);
    add_settings_field('illumina_footer_logo', 'Logo del Footer', 'illumina_logo_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_footer_logo', 'label' => 'Subir Logo Footer']);
    add_settings_field('illumina_header_logo', 'Logo del Header', 'illumina_logo_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_header_logo', 'label' => 'Subir Logo Header']);
    add_settings_field('illumina_address', 'Dirección', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_address', 'placeholder' => 'Tu dirección']);
    add_settings_field('illumina_email', 'Correo Electrónico de Contacto', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_email', 'placeholder' => 'tu.correo@ejemplo.com']);
    add_settings_field('illumina_google_maps', 'Enlace de Google Maps', 'illumina_text_field_callback', 'illumina-settings', 'illumina_main_section', ['name' => 'illumina_google_maps', 'placeholder' => 'Enlace de Google Maps']);
}
add_action('admin_init', 'illumina_register_settings');

// Callback para campos de texto
function illumina_text_field_callback($args) {
    $name = $args['name'];
    $placeholder = $args['placeholder'];
    $value = get_option($name);
    echo "<div class='illumina-field'>";
    echo "<input type='text' name='$name' value='$value' placeholder='$placeholder' class='regular-text'>";
    echo "</div>";
}

// Callback para campos de logo
function illumina_logo_field_callback($args) {
    $name = $args['name'];
    $value = get_option($name);
    $label = $args['label'];
    
    echo '<div class="illumina-logo-field">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<div class="logo-preview-container">';
    if ($value) {
        echo '<img src="' . esc_url($value) . '" class="logo-preview" alt="Logo preview">';
    } else {
        echo '<div class="logo-placeholder">';
        echo '<span class="dashicons dashicons-format-image"></span>';
        echo '<p>Haga clic para seleccionar una imagen</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '<input type="hidden" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" value="' . esc_attr($value) . '">';
    echo '</div>';
}

// Función para encolar estilos y scripts de admin
function illumina_admin_assets($hook) {
    if ('appearance_page_illumina-settings' !== $hook) {
        return;
    }
    
    wp_enqueue_media();
    
    $version = wp_get_theme()->get('Version');

    // Encolar CSS de admin
    wp_enqueue_style(
        'illumina-admin-css',
        get_template_directory_uri() . '/assets/css/admin/admin.css',
        [],
        $version
    );

    // Encolar JS de admin
    wp_enqueue_script(
        'illumina-admin-js',
        get_template_directory_uri() . '/assets/js/admin/admin.js',
        ['jquery'],
        $version,
        true
    );
}
add_action('admin_enqueue_scripts', 'illumina_admin_assets');
