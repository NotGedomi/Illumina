<?php

/*
    Template name: Course Data Array
    Description: Ejemplo de página para traer los datos de un Curso de Sensei / Woocommerce

*/

// Uso de la función get_program_data() para traer los datos de un curso de Sensei en relación con Woocommerce
$programa_data = get_program_data(); // Le pasas un ID Producto de ejemplo

// Verificar si el array no está vacío
if (!empty($program_data)) {
    echo "<ul>";
    
    // Recorrer el array
    foreach ($program_data as $key => $value) {
        if (is_array($value)) {

            // Si el valor es un array, recorrelo recursivamente
            echo "<li>$key:</li>";
            echo "<ul>";
            if ($key == 'lessons') {

                // Caso especial para el array 'lessons'
                foreach ($value as $lesson) {
                    echo "<li>";
                    foreach ($lesson as $lessonKey => $lessonValue) {
                        echo "$lessonKey: $lessonValue<br>";
                    }
                    echo "</li>";
                }
            } else {

                // Otros arrays anidados
                foreach ($value as $subkey => $subvalue) {
                    if (is_array($subvalue)) {
                        echo "<li>$subkey:</li>";
                        echo "<ul>";
                        foreach ($subvalue as $subsubkey => $subsubvalue) {
                            echo "<li>$subsubkey: $subsubvalue</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<li>$subkey: $subvalue</li>";
                    }
                }
            }
            echo "</ul>";
        } else {
            echo "<li>$key: $value</li>";
        }
    }
    
    echo "</ul>";
} else {
    echo "El array está vacío.";
}