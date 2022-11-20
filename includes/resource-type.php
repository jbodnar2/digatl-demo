<?php

/* 
Resource type demo
*/

add_action("init", "register_resource_type");

function register_resource_type()
{
    $labels = [
        "name" => "Resources",
        "all_items" => "All Resources",
        "singular_name" => "Resource",
        "add_new" => "Add New Resource",
        "edit_item" => "Edit Resource",
        "new_item" => "New Resource",
        "view_item" => "View Resource",
        "view_items" => "View Resources",
        "search_items" => "Search Resources",
        "archives" => "Resource Archives",
        "attributes" => "Resource Attributes",
        "featured_image" => "Resource Image",
        "set_featured_image" => "Set Resource Image",
        "remove_featured_image" => "Remove Resource Image",
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
        "taxonomies" => ["category", "post_tag", "resource_format"],
    ];

    register_post_type("resource", $settings);

    unset($settings);
    unset($labels);
}

// Set up "default" custom fields/metadata on initial resource creation
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

        // add_post_meta(
        //     get_the_ID(),
        //     "resource_format",
        //     "Please add the resource format",
        //     true
        // );

        add_post_meta(
            get_the_ID(),
            "resource_creator",
            "Please add the resource's creator",
            true
        );
    }
    return true;
}

// Register the resource_format taxonomy. Use hierarchical to allow checkbox format
add_action("init", "register_resource_format_taxonomy");

function register_resource_format_taxonomy()
{
    $labels = [
        "name" => "Formats",
        "singular_name" => "Format",
    ];

    $settings = [
        "labels" => $labels,
        "hierarchical" => true,
        "rewrite" => true,
        "query_var" => true,
        "show_admin_column" => true,
        "show_in_rest" => true,
    ];

    register_taxonomy("format", "resource", $settings);

    wp_insert_term("ArcGIS StoryMap", "format");
    wp_insert_term("Omeka Exhibit", "format");
    wp_insert_term("ESRI StoryMap", "format");
    wp_insert_term("Website", "format");
    wp_insert_term("Various Media", "format");
    wp_insert_term("ArcGIS Online", "format");
    wp_insert_term("Digital Collection", "format");

    wp_insert_term("Advocacy & Social Change", "category");
    wp_insert_term("Environment & Health", "category");
    wp_insert_term("History, Arts & Culture", "category");
    wp_insert_term("Policy & Planning", "category");

    unset($labels);
    unset($settings);
}
