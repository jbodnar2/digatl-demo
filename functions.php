<?php

add_action("after_setup_theme", "digatl_theme_support");

function digatl_theme_support()
{
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails", ["resource"]);
}

add_action("init", "add_categories_tags_to_pages");

function add_categories_tags_to_pages()
{
    register_taxonomy_for_object_type("category", "page");
    register_taxonomy_for_object_type("post_tag", "page");
}

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

add_action("init", "register_resource_type");

function register_resource_type()
{
    $resourceSettings = [
        "supports" => [
            "editor",
            "title",
            "excerpt",
            "revisions",
            "thumbnail",
            "custom-fields",
        ],
        "labels" => [
            "name" => "Resource",
        ],
        "public" => true,
        "description" => "Project, data or digital collection",
        "menu_position" => 20,
        "taxonomies" => ["category", "post_tag"],
    ];

    register_post_type("resource", $resourceSettings);

    unset($resourceSettings);
}
