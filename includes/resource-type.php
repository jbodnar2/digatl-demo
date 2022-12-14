<?php

/* 
Resource type demo
*/

// Register CPT resource
add_action("init", "register_resource_type");

function register_resource_type()
{
    // Missing a few. Review full set of options.
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

    // Don't seem to be able to map "manage_categories" specifically for a CPT
    $capabilities = [
        "edit_post" => "edit_resource",
        "edit_posts" => "edit_resources",
        "edit_others_posts" => "edit_other_resources",
        "publish_posts" => "publish_resources",
        "read_post" => "read_resource",
        "read_private_posts" => "read_private_resources",
        "delete_post" => "delete_resource",
        // "manage_categories" => "manage_resource_categories",
    ];

    // Note: thumbnail support is required along with theme support for post-thumbnails
    // Note: map_meta_caps is required (true) in order to map capabilities
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
// On initial update, if editor ha sselected to display custmo fiels, the required custom fields will preopulate and show up.
// This is just for demo purposes
add_action("wp_insert_post", "digatl_resource_default_metadata");

function digatl_resource_default_metadata()
{
    if ("resource" === get_post_type(get_the_ID())) {
        $has_resource_url = !!get_post_meta(
            get_the_ID(),
            "resource_url",
            "single"
        );

        $has_resource_creator = !!get_post_meta(
            get_the_ID(),
            "resource_creator",
            "single"
        );

        if (!$has_resource_url) {
            add_post_meta(get_the_ID(), "resource_url", esc_url("/"), true);
        }

        if (!$has_resource_creator) {
            add_post_meta(
                get_the_ID(),
                "resource_creator",
                "No resource creator provided",
                true
            );
        }
    }
    return true;
}

// On updates to resource URL be sure to esc_url() any changes
// Again, just for demo purposes
add_action("pre_post_update", "digatl_resource_validate_url");

function digatl_resource_validate_url()
{
    if ("resource" === get_post_type(get_the_ID())) {
        $resource_url = get_post_meta(get_the_ID(), "resource_url", true);

        if ($resource_url) {
            update_post_meta(
                get_the_ID(),
                "resource_url",
                esc_url($resource_url)
            );
        } else {
            add_post_meta(get_the_ID(), "resource_url", esc_url("/"), true);
        }
    }
}

// Register the resourse taxonomies: formats, categories, and tags.
// Seems like "format" is best as a controlled vocab. Why not use a custom taxonomy for it?
// ...also, seed taxonomies (categories, tags, and formats) with default terms
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
        "Collection",
        "Archival Collection",
        "Blog",
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
        "Goverment/State Government",
        "Transportation",
        "People",
        "Uniquely ATL",
        "Project",
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

// All of this is likely unnecessary as by defaut editor and administrator will have the capabilities.
// Disabling full-blown ability for editor to edit and publish posts also messed with ability to use/apply categories
//...and tags so not doing it. Simply hiding menus seems like it might be enough.
add_action("init", "modify_editor_administrator_caps");
function modify_editor_administrator_caps()
{
    $editor = get_role("editor");
    $administrator = get_role("administrator");

    // Issue: Seems also to disable ability to use tags, categories.
    // $caps = [
    //     "edit_pages",
    //     "publish_pages",
    // "edit_posts", // Remove edit_posts removes ability to assign cats, tags :-(
    // "publish_posts", // Remove publish_posts removes ability to assign cats, tags :-(
    // "manage_categories", // Remove manage_categories removes all access to cats, tags :-(
    // ];

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
// If removing abilities doesn't work, ust hide things is fine, I suppose.
add_action("admin_menu", "remove_editor_page_post_tools_comments_menus");

// Just a helper to check if user is editor.
function digatl_check_if_editor()
{
    $user = wp_get_current_user();

    if (in_array("editor", (array) $user->roles)) {
        return true;
    }
    return false;
}

function remove_editor_page_post_tools_comments_menus()
{
    $is_editor = digatl_check_if_editor();
    if ($is_editor) {
        remove_menu_page("edit.php");
        remove_menu_page("edit.php?post_type=page");
        remove_menu_page("tools.php");
        remove_menu_page("edit-comments.php");
    }
}

// WP doesn't assume you want CPTs in main query. So add the the resource CPT to the main query and to category, tags, etc
// Not sure if this is too much or not enough.
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
