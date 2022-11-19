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

    register_post_type("resource", $resourceSettings);

    unset($settings);
    unset($labels);
}
