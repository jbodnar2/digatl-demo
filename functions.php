<?php

add_action("after_setup_theme", "digatl_theme_support");

function digatl_theme_support()
{
    add_theme_support("title-tag");
}

function add_categories_to_pages()
{
    register_taxonomy_for_object_type("category", "page");
}
add_action("init", "add_categories_to_pages");

add_action("wp_enqueue_scripts", "digatl_enqueue_scripts");

function digatl_enqueue_scripts()
{
    wp_enqueue_style(
        "style",
        get_stylesheet_uri(),
        [],
        wp_get_theme()->Version,
        "all"
    );

    wp_enqueue_script(
        "main",
        get_stylesheet_directory_uri() . "/js/main.js",
        [],
        wp_get_theme()->Version,
        true
    );
}
