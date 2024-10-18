<?php
/**
 * Funciones para el registro de usuarios
 *
 * Este archivo contiene todas las funciones necesarias para manejar
 * el registro de usuarios, incluyendo la validación de campos y
 * la integración con WooCommerce y Sensei LMS.
 *
 * @package Illumina
 * @subpackage UserRegistration
 */

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente
}

/**
 * Obtiene los campos de registro personalizados
 * @return array Campos de registro
 */
function get_custom_registration_fields() {
    $fields = array(
        'username' => array(
            'type' => 'text',
            'label' => 'Nombre de usuario',
            'required' => true
        ),
        'email' => array(
            'type' => 'email',
            'label' => 'Correo electrónico',
            'required' => true
        ),
        'password' => array(
            'type' => 'password',
            'label' => 'Contraseña',
            'required' => true
        ),
        'identity_document' => array(
            'type' => 'text',
            'label' => 'Documento de identidad',
            'required' => true
        )
    );

    // Campos de WooCommerce
    if (class_exists('WooCommerce')) {
        $fields['billing_first_name'] = array(
            'type' => 'text',
            'label' => 'Nombre',
            'required' => true
        );
        $fields['billing_last_name'] = array(
            'type' => 'text',
            'label' => 'Apellido',
            'required' => true
        );
        $fields['billing_country'] = array(
            'type' => 'country',
            'label' => 'País',
            'required' => true
        );
        $fields['billing_phone'] = array(
            'type' => 'tel',
            'label' => 'Teléfono',
            'required' => false
        );
    }

    // Campos de Sensei LMS
    if (class_exists('Sensei_Main')) {
        $fields['sensei_course_interests'] = array(
            'type' => 'multiselect',
            'label' => 'Intereses de cursos',
            'required' => false,
            'options' => Sensei()->course->get_all_course_categories()
        );
    }

    return apply_filters('custom_registration_fields', $fields);
}

/**
 * Valida los datos de registro
 * @param array $user_data Datos del usuario
 * @return true|WP_Error True si los datos son válidos, WP_Error en caso contrario
 */
function validate_registration_data($user_data) {
    $required_fields = array('username', 'email', 'password', 'identity_document');
    
    foreach ($required_fields as $field) {
        if (empty($user_data[$field])) {
            return new WP_Error('required_field', "El campo {$field} es requerido.");
        }
    }

    if (!is_email($user_data['email'])) {
        return new WP_Error('invalid_email', 'El correo electrónico no es válido.');
    }

    if (email_exists($user_data['email'])) {
        return new WP_Error('email_exists', 'Este correo electrónico ya está registrado.');
    }

    if (username_exists($user_data['username'])) {
        return new WP_Error('username_exists', 'Este nombre de usuario ya está en uso.');
    }

    $document_validation = validate_identity_document($user_data['identity_document']);
    if (is_wp_error($document_validation)) {
        return $document_validation;
    }

    if (class_exists('WooCommerce')) {
        if (empty($user_data['billing_first_name']) || empty($user_data['billing_last_name'])) {
            return new WP_Error('required_field', 'El nombre y apellido son requeridos.');
        }
    }

    return true;
}

/**
 * Valida el documento de identidad
 * @param string $document Documento de identidad
 * @return true|WP_Error True si es válido, WP_Error si no lo es
 */
function validate_identity_document($document) {
    $document = preg_replace('/[\s-]/', '', $document);

    if (!ctype_digit($document)) {
        return new WP_Error('invalid_document', 'El documento de identidad solo debe contener números.');
    }

    if (strlen($document) < 8 || strlen($document) > 20) {
        return new WP_Error('invalid_document', 'El documento de identidad debe tener entre 8 y 20 dígitos.');
    }

    return true;
}

/**
 * Registra un nuevo usuario
 * @param array $user_data Datos del usuario
 * @return int|WP_Error ID del usuario o error
 */
function custom_register_user($user_data) {
    $validation = validate_registration_data($user_data);
    if (is_wp_error($validation)) {
        return $validation;
    }

    $username = sanitize_user($user_data['username']);
    $email = sanitize_email($user_data['email']);
    $password = esc_attr($user_data['password']);
    $identity_document = sanitize_text_field($user_data['identity_document']);

    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        return $user_id;
    }

    update_user_meta($user_id, 'identity_document', $identity_document);

    if (class_exists('WooCommerce')) {
        update_user_meta($user_id, 'billing_first_name', sanitize_text_field($user_data['billing_first_name']));
        update_user_meta($user_id, 'billing_last_name', sanitize_text_field($user_data['billing_last_name']));
        update_user_meta($user_id, 'billing_country', sanitize_text_field($user_data['billing_country']));
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($user_data['billing_phone']));
    }

    if (class_exists('Sensei_Main') && isset($user_data['sensei_course_interests'])) {
        update_user_meta($user_id, 'sensei_course_interests', array_map('intval', $user_data['sensei_course_interests']));
    }

    // Asignar el rol de estudiante de Sensei
    if (class_exists('Sensei_Learner')) {
        Sensei_Learner::add_learner_role($user_id);
    }

    wp_new_user_notification($user_id, null, 'both');

    return $user_id;
}

/**
 * Maneja el proceso de registro de usuario
 */
function handle_custom_user_registration() {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'custom_user_registration_nonce')) {
        wp_die('Acción no autorizada', 'Error', array('response' => 403));
    }

    $user_data = array();
    $fields = get_custom_registration_fields();

    foreach ($fields as $field_name => $field) {
        if (isset($_POST[$field_name])) {
            $user_data[$field_name] = $_POST[$field_name];
        }
    }

    $result = custom_register_user($user_data);

    if (is_wp_error($result)) {
        $_SESSION['registration_errors'] = $result->get_error_messages();
        wp_redirect(wp_get_referer() ?: home_url());
        exit;
    } else {
        wp_set_current_user($result);
        wp_set_auth_cookie($result);
        wp_redirect(home_url());
        exit;
    }
}

// Añadir las acciones para manejar el registro
add_action('admin_post_nopriv_custom_user_registration', 'handle_custom_user_registration');
add_action('admin_post_custom_user_registration', 'handle_custom_user_registration');