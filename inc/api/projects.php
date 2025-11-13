<?php
/**
 * REST API endpoints for Projects.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', 'ltu_theme_register_projects_endpoint' );
/**
 * Register /ltu/v1/projects endpoint.
 */
function ltu_theme_register_projects_endpoint() {
    register_rest_route(
        'ltu/v1',
        '/projects',
        [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'ltu_theme_rest_get_projects',
            'permission_callback' => '__return_true',
            'args'                => [
                'status' => [
                    'description'       => __( 'Filter by project status slug.', 'ltu-theme' ),
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_key',
                ],
                'client' => [
                    'description'       => __( 'Filter by client name (partial match).', 'ltu-theme' ),
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ],
            ],
        ]
    );
}

/**
 * Handle GET /ltu/v1/projects.
 */
function ltu_theme_rest_get_projects( WP_REST_Request $request ) {
    $status_choices = ltu_theme_project_status_choices();
    $status         = $request->get_param( 'status' );
    $client         = $request->get_param( 'client' );

    $query_args = [
        'post_type'      => 'project',
        'posts_per_page' => -1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'meta_type'      => 'DATE',
        'order'          => 'DESC',
    ];

    $meta_query = [];

    if ( $status && array_key_exists( $status, $status_choices ) ) {
        $meta_query[] = [
            'key'   => 'status',
            'value' => $status,
        ];
    }

    if ( $client ) {
        $meta_query[] = [
            'key'     => 'client_name',
            'value'   => $client,
            'compare' => 'LIKE',
        ];
    }

    if ( ! empty( $meta_query ) ) {
        $query_args['meta_query'] = $meta_query;
    }

    $projects = new WP_Query( $query_args );
    $data     = [];

    if ( $projects->have_posts() ) {
        while ( $projects->have_posts() ) {
            $projects->the_post();
            $project_id = get_the_ID();

            $client_name = get_post_meta( $project_id, 'client_name', true );
            $status_slug = get_post_meta( $project_id, 'status', true ) ?: 'planned';
            $budget      = get_post_meta( $project_id, 'budget', true );
            $start_date  = get_post_meta( $project_id, 'start_date', true );

            $data[] = [
                'id'             => $project_id,
                'title'          => get_the_title(),
                'permalink'      => get_permalink(),
                'client_name'    => $client_name,
                'status'         => [
                    'slug'  => $status_slug,
                    'label' => $status_choices[ $status_slug ] ?? ucfirst( $status_slug ),
                ],
                'budget'         => '' !== $budget && null !== $budget ? (float) $budget : null,
                'start_date'     => $start_date ?: null,
                'excerpt'        => get_the_excerpt(),
                'content'        => apply_filters( 'the_content', get_the_content() ),
                'featured_image' => get_the_post_thumbnail_url( $project_id, 'large' ),
            ];
        }

        wp_reset_postdata();
    }

    return rest_ensure_response( $data );
}
