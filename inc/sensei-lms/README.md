# Illumina - Funciones para Programas Educativos

Este conjunto de funciones permite obtener y manejar datos de programas educativos (cursos y diplomados) en WordPress, utilizando WooCommerce y Sensei LMS.

## Instalación

1. Coloca todos los archivos PHP en la carpeta `inc/` de tu tema.
2. Incluye el archivo principal en tu `functions.php`:

```php
require_once get_template_directory() . '/inc/educational-program-functions.php';
```

## Funciones Disponibles

### 1. Datos del Producto (`program-product-data.php`)

```php
$product_data = get_program_product_data($product_id);
```
Retorna un array con:
- `product_price`: Precio actual del producto
- `sale_price`: Precio de oferta (si existe)
- `product_image`: URL de la imagen principal del producto
- `categories`: Lista de categorías del producto

### 2. Atributos del Programa (`program-attributes.php`)

```php
$attributes = get_program_attributes($product_id);
```
Retorna un array de atributos del producto y sus valores.

### 3. Datos del Programa en Sensei (`program-data.php`)

```php
$sensei_data = get_sensei_program_data($program_id);
```
Retorna un array con:
- `program_name`: Nombre del programa
- `students_count`: Número de estudiantes inscritos
- `lesson_count`: Número total de lecciones
- `modules`: Lista de módulos
- `program_duration`: Duración total del programa

### 4. Estructura del Programa (`program-structure.php`)

```php
$modules = get_program_modules($program_id);
```
Retorna un array de módulos, cada uno con su nombre y lista de lecciones.

### 5. Duración del Programa (`program-duration.php`)

```php
$duration = get_program_duration($program_id);
```
Retorna la duración total del programa en formato legible (ej. "10 horas y 30 minutos").

### 6. Información del Instructor (`instructor-info.php`)

```php
$instructor_info = get_program_instructor_info($program_id);
```
Retorna un array con información del instructor, incluyendo nombre, email y enlaces a redes sociales.

### 7. Valoraciones del Programa (`program-ratings.php`)

```php
$ratings = get_program_ratings($product_id);
```
Retorna un array con:
- `average_rating`: Valoración promedio
- `rating_counts`: Conteo de valoraciones por estrellas
- `total_reviews`: Número total de reseñas

### 8. Todos los Datos del Programa (`program-data-aggregator.php`)

```php
$all_data = get_program_data_by_product_id($product_id);
```
Retorna un array completo con todos los datos combinados del programa educativo.

## Notas Importantes

- Estas funciones requieren que WooCommerce y Sensei LMS estén instalados y activados.
- Algunas funciones utilizan el ID del producto de WooCommerce, mientras que otras usan el ID del programa de Sensei. Asegúrate de usar el ID correcto.
- La función `get_program_data_by_product_id()` es la más completa y combina datos de todas las demás funciones.
- Estas funciones asumen ciertas estructuras de datos en WooCommerce y Sensei. Si has personalizado significativamente estos plugins, es posible que necesites ajustar las funciones.

## Personalización

Puedes modificar estas funciones según tus necesidades específicas. Si necesitas datos adicionales o un formato diferente, edita las funciones correspondientes en los archivos individuales.