<?php

/* 
Resource type demo
*/

add_action("init", "register_resource_type");

function register_resource_type()
{
    $labels = [
        "name" => "Resource",
    ];

    $settings = [
        "supports" => [
            "editor",
            "title",
            "excerpt",
            "revisions",
            "thumbnail",
            "custom-fields",
        ],
        "labels" => $labels,
        "public" => true,
        "description" =>
            "A project, dataset, digital colleciton, or other online resource",
        "menu_position" => 20,
        "taxonomies" => ["category", "post_tag"],
    ];

    register_post_type("resource", $settings);

    unset($settings);
    unset($labels);
}

add_action("wp_insert_post", "digatl_resource_default_metadata");

function digatl_resource_default_metadata()
{
    if ("resource" === get_post_type(get_the_ID())) {
        add_post_meta(
            get_the_ID(),
            "resource_url",
            "Please add the resource URL",
            true
        );

        add_post_meta(
            get_the_ID(),
            "resource_format",
            "Please add the resource format",
            true
        );

        add_post_meta(
            get_the_ID(),
            "resource_creator",
            "Please add the resource's creator",
            true
        );
    }
    return true;
}
