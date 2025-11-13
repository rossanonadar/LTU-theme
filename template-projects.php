<?php
/**
 * Template Name: Projects Listing
 * Description: Displays all projects in a table with meta fields.
 *
 * @package LTU-theme
 */

get_header();

the_post();

$status_choices = ltu_theme_project_status_choices();
$status_filter  = isset( $_GET['project_status'] ) ? sanitize_key( wp_unslash( $_GET['project_status'] ) ) : '';
$client_query   = isset( $_GET['client_query'] ) ? sanitize_text_field( wp_unslash( $_GET['client_query'] ) ) : '';

$query_args = [
    'post_type'      => 'project',
    'posts_per_page' => -1,
    'meta_key'       => 'start_date',
    'orderby'        => 'meta_value',
    'meta_type'      => 'DATE',
    'order'          => 'DESC',
];

$meta_query = [];

if ( $status_filter && array_key_exists( $status_filter, $status_choices ) ) {
    $meta_query[] = [
        'key'   => 'status',
        'value' => $status_filter,
    ];
}

if ( $client_query ) {
    $meta_query[] = [
        'key'     => 'client_name',
        'value'   => $client_query,
        'compare' => 'LIKE',
    ];
}

if ( ! empty( $meta_query ) ) {
    $query_args['meta_query'] = $meta_query;
}

$projects = new WP_Query( $query_args );
?>
<div class="projects-listing">
    <?php 
        get_template_part('template-parts/projects/header', null,
            [
                'title'   => get_the_title(),
                'excerpt' => has_excerpt() ? get_the_excerpt() : '',
            ]
        );

        get_template_part('template-parts/projects/filters', null,
            [
                'status_choices' => $status_choices,
                'selected_status' => $status_filter,
                'client_query'    => $client_query,
                'action_url'      => get_permalink(),
            ]
        );

        get_template_part('template-parts/projects/table', null,
            [
                'projects'       => $projects,
                'status_choices' => $status_choices,
                'show_summary'   => true,
            ]
        );
    ?>
</div>
<?php wp_reset_postdata(); get_footer();
