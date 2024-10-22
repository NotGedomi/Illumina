<?php
/**
 * Obtiene los metadatos personalizados del curso incluyendo traducciones
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

// Añadir campos al metabox de publicación
function add_course_metadata_fields() {
    add_action('post_submitbox_misc_actions', 'render_course_metadata_fields');
}
add_action('admin_init', 'add_course_metadata_fields');

// Renderizar campos en el metabox de publicación
function render_course_metadata_fields() {
    global $post;
    
    if ($post->post_type !== 'course') {
        return;
    }

    wp_nonce_field('course_metadata_nonce', 'course_metadata_nonce');
    
    $is_diplomado = has_term('diplomados', 'course-category', $post->ID);
    $availability_date = get_post_meta($post->ID, '_program_availability_date', true);
    $program_modality = get_post_meta($post->ID, '_program_modality', true);
    $program_credits = get_post_meta($post->ID, '_program_credits', true);
    $program_level = get_post_meta($post->ID, '_program_level', true);
    ?>
    <div class="misc-pub-section">
        <label><strong>Fecha de Disponibilidad:</strong></label><br />
        <input type="date" name="program_availability_date" value="<?php echo esc_attr($availability_date); ?>" />
    </div>

    <?php if ($is_diplomado): ?>
        <div class="misc-pub-section">
            <label><strong>Modalidad:</strong></label><br />
            <select name="program_modality">
                <option value="">Seleccionar modalidad</option>
                <option value="presencial" <?php selected($program_modality, 'presencial'); ?>>Presencial</option>
                <option value="semi_presencial" <?php selected($program_modality, 'semi_presencial'); ?>>Semi Presencial</option>
                <option value="virtual" <?php selected($program_modality, 'virtual'); ?>>Virtual</option>
            </select>
        </div>
    <?php else: ?>
        <div class="misc-pub-section">
            <label><strong>Nivel del Programa:</strong></label><br />
            <select name="program_level" id="program_level">
                <option value="">Seleccionar nivel</option>
                <option value="introductory" <?php selected($program_level, 'introductory'); ?>>Introductorio</option>
                <option value="intermediate" <?php selected($program_level, 'intermediate'); ?>>Intermedio</option>
                <option value="advanced" <?php selected($program_level, 'advanced'); ?>>Avanzado</option>
            </select>
        </div>
        <div class="misc-pub-section">
            <label><strong>Créditos:</strong></label><br />
            <input type="number" name="program_credits" value="<?php echo esc_attr($program_credits); ?>" min="0" step="1" />
        </div>
    <?php endif; ?>
    <?php
}

// Guardar metadatos
function save_course_metadata($post_id) {
    if (!isset($_POST['course_metadata_nonce']) || 
        !wp_verify_nonce($_POST['course_metadata_nonce'], 'course_metadata_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'program_level',
        'program_availability_date',
        'program_modality',
        'program_credits'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_course', 'save_course_metadata');

function get_course_metadata($course_id) {
    $is_diplomado = has_term('diplomados', 'course-category', $course_id);
    
    $metadata = array(
        'availability_date' => get_post_meta($course_id, '_program_availability_date', true)
    );

    // Mapeo de modalidades
    $modality_translations = array(
        'presencial' => 'Presencial',
        'semi_presencial' => 'Semi Presencial',
        'virtual' => 'Virtual'
    );

    if ($is_diplomado) {
        $raw_modality = get_post_meta($course_id, '_program_modality', true);
        $metadata['modality'] = isset($modality_translations[$raw_modality]) ? 
            $modality_translations[$raw_modality] : $raw_modality;
    } else {
        // Mapeo de niveles con traducciones
        $level_translations = array(
            'introductory' => 'Introductorio',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado'
        );

        $raw_level = get_post_meta($course_id, '_program_level', true);
        $metadata['level'] = isset($level_translations[$raw_level]) ? $level_translations[$raw_level] : $raw_level;
        $metadata['raw_level'] = $raw_level;
        $metadata['credits'] = get_post_meta($course_id, '_program_credits', true);
    }

    return $metadata;
}