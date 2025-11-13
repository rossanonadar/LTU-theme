<?php
/**
 * Project post type registration and meta.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'ltu_theme_register_project_post_type' );
/**
 * Register the Project custom post type.
 */
function ltu_theme_register_project_post_type() {
    $labels = [
        'name'               => __( 'Projects', 'ltu-theme' ),
        'singular_name'      => __( 'Project', 'ltu-theme' ),
        'menu_name'          => __( 'Projects', 'ltu-theme' ),
        'name_admin_bar'     => __( 'Project', 'ltu-theme' ),
        'add_new'            => __( 'Add New', 'ltu-theme' ),
        'add_new_item'       => __( 'Add New Project', 'ltu-theme' ),
        'edit_item'          => __( 'Edit Project', 'ltu-theme' ),
        'new_item'           => __( 'New Project', 'ltu-theme' ),
        'view_item'          => __( 'View Project', 'ltu-theme' ),
        'search_items'       => __( 'Search Projects', 'ltu-theme' ),
        'not_found'          => __( 'No projects found.', 'ltu-theme' ),
        'not_found_in_trash' => __( 'No projects found in Trash.', 'ltu-theme' ),
        'all_items'          => __( 'All Projects', 'ltu-theme' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'projects' ],
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
        'show_in_rest'       => true,
    ];

    register_post_type( 'project', $args );
}

add_action( 'init', 'ltu_theme_register_project_meta' );
/**
 * Register the Project meta fields with core APIs.
 */
function ltu_theme_register_project_meta() {
    $fields = [
        'client_name' => [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        'status'      => [
            'type'              => 'string',
            'sanitize_callback' => 'ltu_theme_sanitize_project_status',
        ],
        'budget'      => [
            'type'              => 'number',
            'sanitize_callback' => 'ltu_theme_sanitize_project_budget',
        ],
        'start_date'  => [
            'type'              => 'string',
            'sanitize_callback' => 'ltu_theme_sanitize_project_date',
        ],
    ];

    foreach ( $fields as $key => $args ) {
        register_post_meta(
            'project',
            $key,
            array_merge(
                [
                    'single'            => true,
                    'show_in_rest'      => true,
                    'auth_callback'     => 'ltu_theme_project_meta_auth',
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                $args
            )
        );
    }
}

/**
 * Limit meta editing to users who can edit the project.
 */
function ltu_theme_project_meta_auth( $allowed, $meta_key, $post_id ) {
    return current_user_can( 'edit_post', $post_id );
}

/**
 * Ensure the select status matches the allowed options.
 */
function ltu_theme_sanitize_project_status( $value ) {
    $choices = array_keys( ltu_theme_project_status_choices() );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'planned';
}

/**
 * Force budget values to numbers.
 */
function ltu_theme_sanitize_project_budget( $value ) {
    if ( '' === $value || null === $value ) {
        return '';
    }

    return floatval( $value );
}

/**
 * Store ISO date strings (YYYY-MM-DD).
 */
function ltu_theme_sanitize_project_date( $value ) {
    $value = sanitize_text_field( $value );

    if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $value ) ) {
        return $value;
    }

    return '';
}

/**
 * Reusable list of status choices.
 */
function ltu_theme_project_status_choices() {
    return [
        'planned'     => __( 'Planned', 'ltu-theme' ),
        'in-progress' => __( 'In Progress', 'ltu-theme' ),
        'completed'   => __( 'Completed', 'ltu-theme' ),
    ];
}
