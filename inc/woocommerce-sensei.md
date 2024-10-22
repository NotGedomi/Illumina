# Documentación de Funciones - Sistema de Cursos y Productos

Esta documentación describe todas las funciones disponibles para manejar cursos, productos y sus relaciones en el sistema. Las funciones están organizadas por categorías para facilitar su uso.

## Índice
- [Funciones de Sensei (Cursos)](#funciones-de-sensei-cursos)
- [Funciones de WooCommerce](#funciones-de-woocommerce)
- [Funciones de Relación](#funciones-de-relación)

## Funciones de Sensei (Cursos)

### get_course_modules($course_id)
Obtiene la lista de módulos de un curso específico.

```php
$modules = get_course_modules(123);
// Retorna:
[
    [
        'module_id' => 1,
        'module_name' => 'Introducción a PHP'
    ],
    [
        'module_id' => 2,
        'module_name' => 'Programación Orientada a Objetos'
    ]
]
```

### get_course_structure($course_id)
Obtiene la estructura completa del curso incluyendo módulos y lecciones.

```php
$structure = get_course_structure(123);
// Retorna:
[
    'modules' => [
        [
            'module_name' => 'Introducción a PHP',
            'module_id' => 1,
            'module_description' => 'Fundamentos de PHP',
            'lessons' => [
                [
                    'lesson_name' => 'Variables y Tipos',
                    'lesson_id' => 10,
                    'lesson_duration' => '30'
                ]
            ],
            'lessons_count' => 1
        ]
    ],
    'modules_count' => 1,
    'lessons' => [], // Lecciones sin módulo
    'lesson_count' => 1
]
```

### get_module_lessons($course_id, $module_id)
Obtiene las lecciones de un módulo específico.

```php
$lessons = get_module_lessons(123, 1);
// Retorna:
[
    [
        'lesson_id' => 10,
        'lesson_name' => 'Variables y Tipos',
        'lesson_duration' => '30'
    ]
]
```

### get_course_certifications_count($course_id)
Calcula el número total de certificaciones disponibles en el curso.

```php
$certifications = get_course_certifications_count(123);
// Retorna: 3 (número total de certificaciones)
```

### get_course_duration_info($course_id)
Calcula la información de duración del curso.

```php
$duration = get_course_duration_info(123);
// Retorna:
[
    'total_minutes' => 180,
    'hours' => 3,
    'minutes' => 0,
    'weeks' => 1,
    'months' => 1,
    'formatted_duration' => '3 horas',
    'estimated_duration' => '1 semanas'
]
```

### get_course_instructor_info($course_id)
Obtiene la información detallada del instructor del curso.

```php
$instructor = get_course_instructor_info(123);
// Retorna:
[
    'instructor_name' => 'Juan Pérez',
    'instructor_email' => 'juan@ejemplo.com',
    'instructor_id' => 1,
    'instructor_bio' => 'Biografía del instructor',
    'instructor_profile_image' => 'https://ejemplo.com/imagen.jpg',
    'instructor_facebook' => 'https://facebook.com/juan',
    'instructor_linkedin' => 'https://linkedin.com/in/juan',
    'instructor_instagram' => 'https://instagram.com/juan'
]
```

### get_course_lessons($course_id)
Obtiene todas las lecciones del curso, incluyendo las que están en módulos y las independientes.

```php
$lessons = get_course_lessons(123);
// Retorna:
[
    [
        'lesson_id' => 10,
        'lesson_name' => 'Variables y Tipos',
        'module_id' => 1,
        'module_name' => 'Introducción a PHP',
        'lesson_duration' => '30'
    ]
]
```

### get_course_metadata($course_id)
Obtiene los metadatos personalizados del curso incluyendo traducciones.

```php
$metadata = get_course_metadata(123);
// Retorna:
[
    'availability_date' => '2024-04-01',
    'level' => 'Intermedio',
    'raw_level' => 'intermediate',
    // Para diplomados:
    'modality' => 'Presencial',
    // Para cursos:
    'credits' => '3'
]
```

## Funciones de WooCommerce

### get_product_attributes($product_id)
Obtiene los atributos personalizados del producto.

```php
$attributes = get_product_attributes(123);
// Retorna:
[
    [
        'label' => 'Nivel',
        'values' => ['Básico', 'Intermedio', 'Avanzado']
    ]
]
```

### get_product_average_rating($product_id)
Calcula el promedio de calificaciones del producto.

```php
$rating = get_product_average_rating(123);
// Retorna: 4.5
```

### get_product_data($product_id)
Obtiene los datos básicos de un producto.

```php
$data = get_product_data(123);
// Retorna:
[
    'price' => '$99.99',
    'regular_price' => '$129.99',
    'sale_price' => '$99.99',
    'categories' => ['Cursos', 'Programación']
]
```

### get_product_image($product_id)
Obtiene la URL de la imagen principal del producto.

```php
$image_url = get_product_image(123);
// Retorna: 'https://ejemplo.com/imagen.jpg'
```

### get_product_rating_counts($product_id)
Obtiene el conteo de calificaciones por número de estrellas.

```php
$ratings = get_product_rating_counts(123);
// Retorna:
[
    1 => 2,  // 2 reseñas de 1 estrella
    2 => 3,  // 3 reseñas de 2 estrellas
    3 => 5,  // 5 reseñas de 3 estrellas
    4 => 10, // 10 reseñas de 4 estrellas
    5 => 15  // 15 reseñas de 5 estrellas
]
```

### get_product_reviews($product_id)
Obtiene las reseñas del producto con sus detalles.

```php
$reviews = get_product_reviews(123);
// Retorna:
[
    [
        'id' => 1,
        'rating' => 5,
        'author' => 'Juan Pérez',
        'date' => '2024-03-20 10:30:00',
        'content' => 'Excelente curso'
    ]
]
```

### get_all_product_categories()
Obtiene todas las categorías de productos con sus datos completos.

```php
$categories = get_all_product_categories();
// Retorna:
[
    [
        'id' => 1,
        'name' => 'Cursos',
        'slug' => 'cursos',
        'description' => 'Todos los cursos',
        'parent_id' => 0,
        'count' => 10,
        'url' => 'https://ejemplo.com/categoria/cursos',
        'thumbnail' => [
            'id' => 123,
            'url' => 'https://ejemplo.com/imagen.jpg',
            'thumbnail_url' => 'https://ejemplo.com/imagen-150x150.jpg',
            'medium_url' => 'https://ejemplo.com/imagen-300x300.jpg'
        ]
    ]
]
```

### get_parent_product_categories()
Obtiene solo las categorías padre de productos.

```php
$parents = get_parent_product_categories();
// Retorna mismo formato que get_all_product_categories pero solo categorías padre
```

### get_child_product_categories($parent_id)
Obtiene las categorías hijas de una categoría específica.

```php
$children = get_child_product_categories(1);
// Retorna mismo formato que get_all_product_categories pero solo las hijas
```

### get_category_products($category_id, $per_page = -1, $page = 1)
Obtiene los productos de una categoría específica con paginación.

```php
$products = get_category_products(1, 10, 1);
// Retorna:
[
    'products' => [
        [
            'id' => 123,
            'name' => 'Curso de PHP',
            'slug' => 'curso-php',
            'price' => '99.99',
            'regular_price' => '129.99',
            'sale_price' => '99.99',
            'description' => 'Descripción completa',
            'short_description' => 'Descripción corta',
            'images' => [
                'id' => 456,
                'url' => 'https://ejemplo.com/imagen.jpg',
                'thumbnail_url' => 'https://ejemplo.com/imagen-150x150.jpg',
                'medium_url' => 'https://ejemplo.com/imagen-300x300.jpg'
            ],
            'url' => 'https://ejemplo.com/curso-php',
            'average_rating' => 4.5,
            'review_count' => 35,
            'stock_status' => 'instock'
        ]
    ],
    'total' => 50,    // Total de productos
    'pages' => 5      // Total de páginas
]
```

## Funciones de Relación

### get_product_course_relation($product_id)
Obtiene la relación entre un producto de WooCommerce y su curso de Sensei.

```php
$relation = get_product_course_relation(123);
// Retorna:
[
    'course_id' => 456,
    'course_name' => 'Curso de PHP',
    'course_content' => 'Contenido del curso'
]
```

## Uso Combinado de Funciones

Ejemplo de cómo obtener información completa de un curso con su producto asociado:

```php
// Obtener producto y curso relacionado
$product_id = 123;
$relation = get_product_course_relation($product_id);
$course_id = $relation['course_id'];

// Obtener datos del producto
$product_data = get_product_data($product_id);
$product_rating = get_product_average_rating($product_id);
$product_reviews = get_product_reviews($product_id);

// Obtener datos del curso
$course_structure = get_course_structure($course_id);
$course_duration = get_course_duration_info($course_id);
$course_instructor = get_course_instructor_info($course_id);
$course_metadata = get_course_metadata($course_id);

// Combinar toda la información
$complete_info = [
    'product' => $product_data,
    'rating' => $product_rating,
    'reviews' => $product_reviews,
    'course' => [
        'structure' => $course_structure,
        'duration' => $course_duration,
        'instructor' => $course_instructor,
        'metadata' => $course_metadata
    ]
];
```

Este es un ejemplo básico de cómo combinar múltiples funciones para obtener información completa de un curso y su producto asociado.

