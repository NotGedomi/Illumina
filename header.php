<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <?php if (is_404()): ?>
        <title><?php esc_attr_e("InVitro | Página de Error"); ?></title>
    <?php else: ?>
        <title><?php the_title(); ?></title>
    <?php endif; ?>

</head>

<body <?php body_class(); ?>>
    <?php include(get_template_directory() . '/components/header/center/center.php'); ?>