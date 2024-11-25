<?php
function custom_get_header($class = '')
{
    $args = array();
    if (!empty($class)) {
        $args['class'] = $class;
    }
    get_header(null, $args);
}

function custom_get_footer($class = '')
{
    $args = array();
    if (!empty($class)) {
        $args['class'] = $class;
    }
    get_footer(null, $args);
}