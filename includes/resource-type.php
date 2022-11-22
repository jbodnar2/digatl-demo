<?php

/* 
Resource type demo
*/

// Register CPT resource
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

    $capabilities = [
        "edit_post" => "edit_resource",
        "edit_posts" => "edit_resources",
        "edit_others_posts" => "edit_other_resources",
        "publish_posts" => "publish_resources",
        "read_post" => "read_resource",
        "read_private_posts" => "read_private_resources",
        "delete_post" => "delete_resource",
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
        "taxonomies" => ["category", "post_tag", "format"],
        "capabilities" => $capabilities,
        "map_meta_cap" => true,
    ];

    register_post_type("resource", $settings);

    unset($settings);
    unset($labels);
    unset($capabilities);
}

// Set up "default" custom fields/metadata on initial resource creation
add_action("wp_insert_post", "digatl_resource_default_metadata");

function digatl_resource_default_metadata()
{
    if ("resource" === get_post_type(get_the_ID())) {
        add_post_meta(get_the_ID(), "resource_url", esc_url("/"), true);

        add_post_meta(
            get_the_ID(),
            "resource_creator",
            "Please add the resource's creator",
            true
        );
    }
    return true;
}

// Register the resourse taxonomies: formats, categories, and tags.
add_action("init", "register_format_taxonomies");

function register_format_taxonomies()
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

    $default_formats = [
        "ArcGIS StoryMap",
        "Omeka Exhibit",
        "ESRI StoryMap",
        "Website",
        "Various Media",
        "ArcGiS Online",
        "Digital Collection",
        "Matterport 3D Scans",
        "360 Timelapse Video",
    ];

    foreach ($default_formats as $format) {
        wp_insert_term($format, "format");
    }

    $default_categories = [
        "Advocacy & Social Change",
        "Environment & Health",
        "History, Arts & Culture",
        "Policy & Planning",
    ];

    foreach ($default_categories as $category) {
        wp_insert_term($category, "category");
    }

    $default_tags = [
        "Built Environment",
        "Natural Environment",
        "Education",
        "Housing & Population",
        "Goverment / State Government",
        "Transportation",
        "People",
        "Uniquely ATL",
    ];

    foreach ($default_tags as $tag) {
        wp_insert_term($tag, "post_tag");
    }

    unset($labels);
    unset($settings);
    unset($default_formats);
    unset($default_categories);
    unset($default_tags);
}

add_action("init", "modify_editor_administrator_caps");

function modify_editor_administrator_caps()
{
    $editor = get_role("editor");
    $administrator = get_role("administrator");

    // Issue: Seems also to disable ability to use tags, categories.
    // $caps = ["edit_pages", "publish_pages", "edit_posts", "publish_posts"];

    // foreach ($caps as $cap) {
    //     $editor->remove_cap($cap);
    // }

    $resource_caps = [
        "edit_resource",
        "edit_resources",
        "edit_other_resources",
        "publish_resources",
        "read_resource",
        "read_private_resources",
        "delete_resource",
    ];

    foreach ($resource_caps as $cap) {
        $administrator->add_cap($cap);
        $editor->add_cap($cap);
    }
}

// Quick fix for removing posts, pages from editor screen
function digatl_check_if_editor()
{
    $user = wp_get_current_user();

    if (in_array("editor", (array) $user->roles)) {
        return true;
    }
    return false;
}

add_action("admin_menu", function () {
    $is_editor = digatl_check_if_editor();
    if ($is_editor) {
        remove_menu_page("edit.php");
        remove_menu_page("edit.php?post_type=page");
        remove_menu_page("tools.php");
        remove_menu_page("edit-comments.php");
    }
});

add_filter("pre_get_posts", "digatl_add_resource_archives");

function digatl_add_resource_archives($query)
{
    if (
        is_category() ||
        (is_tag() && empty($query->query_vars["suppress_filters"]))
    ) {
        $query->set("post_type", ["post", "nav_menu_item", "resource"]);
        return $query;
    }

    if (is_home() && $query->is_main_query()) {
        $query->set("post_type", ["resource"]);
        return $query;
    }
}
