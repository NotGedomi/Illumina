<?php
/**
 * Gestión de metadatos personalizados para cursos
 * 
 * Este archivo maneja la creación, renderizado y almacenamiento de metadatos
 * personalizados para cursos, incluyendo objetivo del curso, público dirigido,
 * modalidad, nivel y créditos.
 * 
 * @package Illumina
 * @subpackage Sensei
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registra el metabox para los campos personalizados
 */
function add_course_metadata_box() {
    add_meta_box(
        'course_metadata_box',
        'Información del Programa',
        'render_course_metadata_fields',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_course_metadata_box');

/**
 * Renderiza los campos del metabox
 * 
 * @param WP_Post $post Objeto post actual
 */
function render_course_metadata_fields($post) {
    wp_nonce_field('course_metadata_nonce', 'course_metadata_nonce');
    
    // Obtener datos
    $is_diplomado = has_term('diplomados', 'course-category', $post->ID);
    $metadata = array(
        'availability_date' => get_post_meta($post->ID, '_program_availability_date', true),
        'program_modality' => get_post_meta($post->ID, '_program_modality', true),
        'program_credits' => get_post_meta($post->ID, '_program_credits', true),
        'program_level' => get_post_meta($post->ID, '_program_level', true),
        'publico_dirigido' => get_post_meta($post->ID, '_programa_publico_dirigido', true),
        'objetivo_curso' => get_post_meta($post->ID, '_programa_objetivo', true),
        'beneficio_curso' => get_post_meta($post->ID, '_programa_beneficio', true)
    );

    // Convertir público dirigido a array
    $publico_items = !empty($metadata['publico_dirigido']) ? 
        json_decode($metadata['publico_dirigido'], true) : array('');
    ?>
    <style>
        .course-metadata-wrapper {
            padding: 12px;

            .field-group {
                margin-bottom: 15px;

                label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }

                textarea,
                input[type="date"],
                select {
                    width: 100%;
                }

                .description {
                    color: #666;
                    font-style: italic;
                    margin-top: 3px;
                }
            }

            .publico-item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 10px;

                input {
                    flex: 1;
                }

                .remove-item {
                    color: #dc3232;
                    cursor: pointer;
                    padding: 5px;
                }
            }

            .add-publico-item {
                margin-top: 10px;
            }
        }
    </style>

    <div class="course-metadata-wrapper">
        <!-- Fecha de Disponibilidad -->
        <div class="field-group">
            <label>Fecha de Disponibilidad:</label>
            <input type="date" 
                   name="program_availability_date" 
                   value="<?php echo esc_attr($metadata['availability_date']); ?>" />
        </div>

        <?php if ($is_diplomado): ?>
            <!-- Objetivo del Curso (solo diplomados) -->
            <div class="field-group">
                <label>Objetivo del Diplomado:</label>
                <textarea name="programa_objetivo" 
                          rows="3"><?php echo esc_textarea($metadata['objetivo_curso']); ?></textarea>
                <p class="description">Describe brevemente el objetivo principal del diplomado</p>
            </div>

            <!-- Beneficio del Curso (solo diplomados) -->
            <div class="field-group">
                <label>Beneficios del Diplomado:</label>
                <textarea name="programa_beneficio" 
                          rows="3"><?php echo esc_textarea($metadata['beneficio_curso']); ?></textarea>
                <p class="description">Describe los beneficios que obtendrá el estudiante</p>
            </div>
        <?php endif; ?>

        <!-- Público Dirigido -->
        <div class="field-group">
            <label>Público Dirigido:</label>
            <div id="publico-items-container">
                <?php foreach ($publico_items as $item): ?>
                    <div class="publico-item">
                        <input type="text" 
                               name="programa_publico_dirigido[]" 
                               value="<?php echo esc_attr($item); ?>" />
                        <span class="remove-item dashicons dashicons-no-alt"></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-publico-item">Añadir Perfil</button>
        </div>

        <?php if ($is_diplomado): ?>
            <!-- Modalidad (solo para diplomados) -->
            <div class="field-group">
                <label>Modalidad:</label>
                <select name="program_modality">
                    <option value="">Seleccionar modalidad</option>
                    <option value="presencial" <?php selected($metadata['program_modality'], 'presencial'); ?>>
                        Presencial
                    </option>
                    <option value="semi_presencial" <?php selected($metadata['program_modality'], 'semi_presencial'); ?>>
                        Semi Presencial
                    </option>
                    <option value="virtual" <?php selected($metadata['program_modality'], 'virtual'); ?>>
                        Virtual
                    </option>
                </select>
            </div>
        <?php else: ?>
            <!-- Nivel y Créditos (para cursos no diplomados) -->
            <div class="field-group">
                <label>Nivel del Programa:</label>
                <select name="program_level" id="program_level">
                    <option value="">Seleccionar nivel</option>
                    <option value="introductory" <?php selected($metadata['program_level'], 'introductory'); ?>>
                        Introductorio
                    </option>
                    <option value="intermediate" <?php selected($metadata['program_level'], 'intermediate'); ?>>
                        Intermedio
                    </option>
                    <option value="advanced" <?php selected($metadata['program_level'], 'advanced'); ?>>
                        Avanzado
                    </option>
                </select>
            </div>
            <div class="field-group">
                <label>Créditos:</label>
                <input type="number" 
                       name="program_credits" 
                       value="<?php echo esc_attr($metadata['program_credits']); ?>" 
                       min="0" 
                       step="1" />
            </div>
        <?php endif; ?>
    </div>

    <script>
    jQuery(document).ready(function($) {
        const publicoContainer = $('#publico-items-container');
        
        // Añadir nuevo ítem
        $('.add-publico-item').on('click', function() {
            const newItem = `
                <div class="publico-item">
                    <input type="text" name="programa_publico_dirigido[]" value="" />
                    <span class="remove-item dashicons dashicons-no-alt"></span>
                </div>
            `;
            publicoContainer.append(newItem);
        });

        // Eliminar ítem
        publicoContainer.on('click', '.remove-item', function() {
            const item = $(this).parent();
            if (publicoContainer.children().length > 1) {
                item.remove();
            } else {
                item.find('input').val('');
            }
        });
    });
    </script>
    <?php
}

/**
 * Guarda los metadatos del curso
 * 
 * @param int $post_id ID del post
 */
function save_course_metadata($post_id) {
    if (!isset($_POST['course_metadata_nonce']) || 
        !wp_verify_nonce($_POST['course_metadata_nonce'], 'course_metadata_nonce') ||
        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||
        !current_user_can('edit_post', $post_id)) {
        return;
    }

    // Guardar público dirigido como JSON
    if (isset($_POST['programa_publico_dirigido'])) {
        $publico_items = array_map('wp_unslash', array_filter($_POST['programa_publico_dirigido']));
        $publico_items = array_map('sanitize_text_field', $publico_items);
        update_post_meta($post_id, '_programa_publico_dirigido', wp_json_encode($publico_items, JSON_UNESCAPED_UNICODE));
    }

    // Guardar objetivo y beneficio solo si es diplomado
    if (has_term('diplomados', 'course-category', $post_id)) {
        if (isset($_POST['programa_objetivo'])) {
            $objetivo = wp_unslash($_POST['programa_objetivo']);
            update_post_meta($post_id, '_programa_objetivo', wp_kses_post($objetivo));
        }
        if (isset($_POST['programa_beneficio'])) {
            $beneficio = wp_unslash($_POST['programa_beneficio']);
            update_post_meta($post_id, '_programa_beneficio', wp_kses_post($beneficio));
        }
    }

    // Guardar otros campos
    $fields = array(
        'program_level',
        'program_availability_date',
        'program_modality',
        'program_credits'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}
add_action('save_post_course', 'save_course_metadata');

/**
 * Obtiene los metadatos del curso
 * 
 * @param int $course_id ID del curso
 * @return array Metadatos del curso
 */
function get_course_metadata($course_id) {
    $is_diplomado = has_term('diplomados', 'course-category', $course_id);
    
    // Datos base
    $publico_dirigido = get_post_meta($course_id, '_programa_publico_dirigido', true);
    $metadata = array(
        'availability_date' => get_post_meta($course_id, '_program_availability_date', true),
        'publico_dirigido' => !empty($publico_dirigido) ? json_decode($publico_dirigido, true) : array()
    );

    // Traducciones
    $translations = array(
        'modality' => array(
            'presencial' => 'Presencial',
            'semi_presencial' => 'Semi Presencial',
            'virtual' => 'Virtual'
        ),
        'level' => array(
            'introductory' => 'Introductorio',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado'
        )
    );

    if ($is_diplomado) {
        $metadata['objetivo'] = get_post_meta($course_id, '_programa_objetivo', true);
        $metadata['beneficio'] = get_post_meta($course_id, '_programa_beneficio', true);
        $raw_modality = get_post_meta($course_id, '_program_modality', true);
        $metadata['modality'] = isset($translations['modality'][$raw_modality]) ? 
            $translations['modality'][$raw_modality] : $raw_modality;
    } else {
        $raw_level = get_post_meta($course_id, '_program_level', true);
        $metadata['level'] = isset($translations['level'][$raw_level]) ? 
            $translations['level'][$raw_level] : $raw_level;
        $metadata['raw_level'] = $raw_level;
        $metadata['credits'] = get_post_meta($course_id, '_program_credits', true);
    }

    return $metadata;
}