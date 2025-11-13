<?php
/**
 * Admin list table columns, sorting, and filters for Projects.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'manage_project_posts_columns', 'ltu_theme_project_admin_columns' );
/**
 * Add custom columns to the Projects list table.
 */
function ltu_theme_project_admin_columns( $columns ) {
    $ordered = [];

    foreach ( $columns as $key => $label ) {
        $ordered[ $key ] = $label;

        if ( 'title' === $key ) {
            $ordered['client_name'] = __( 'Client', 'ltu-theme' );
            $ordered['status']      = __( 'Status', 'ltu-theme' );
            $ordered['budget']      = __( 'Budget', 'ltu-theme' );
            $ordered['start_date']  = __( 'Start Date', 'ltu-theme' );
        }
    }

    return $ordered;
}

add_action( 'manage_project_posts_custom_column', 'ltu_theme_project_column_content', 10, 2 );
/**
 * Populate the custom columns.
 */
function ltu_theme_project_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'client_name':
            echo esc_html( get_post_meta( $post_id, 'client_name', true ) );
            break;
        case 'status':
            $status      = get_post_meta( $post_id, 'status', true ) ?: 'planned';
            $status_opts = ltu_theme_project_status_choices();
            echo esc_html( $status_opts[ $status ] ?? $status );
            break;
        case 'budget':
            $budget = get_post_meta( $post_id, 'budget', true );
            if ( '' !== $budget && null !== $budget ) {
                echo esc_html( number_format_i18n( floatval( $budget ), 2 ) );
            }
            break;
        case 'start_date':
            $date = get_post_meta( $post_id, 'start_date', true );
            if ( $date ) {
                echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) );
            }
            break;
    }
}

add_filter( 'manage_edit-project_sortable_columns', 'ltu_theme_project_sortable_columns' );
/**
 * Mark columns as sortable.
 */
function ltu_theme_project_sortable_columns( $columns ) {
    $columns['status']     = 'status';
    $columns['budget']     = 'budget';
    $columns['start_date'] = 'start_date';
    return $columns;
}

add_action( 'pre_get_posts', 'ltu_theme_project_admin_ordering' );
/**
 * Handle sorting/filter logic.
 */
function ltu_theme_project_admin_ordering( WP_Query $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'project' !== $query->get( 'post_type' ) ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    switch ( $orderby ) {
        case 'budget':
            $query->set( 'meta_key', 'budget' );
            $query->set( 'orderby', 'meta_value_num' );
            break;
        case 'start_date':
            $query->set( 'meta_key', 'start_date' );
            $query->set( 'orderby', 'meta_value' );
            break;
        case 'status':
            $query->set( 'meta_key', 'status' );
            $query->set( 'orderby', 'meta_value' );
            break;
    }

    if ( isset( $_GET['ltu_project_status_filter'] ) && $_GET['ltu_project_status_filter'] ) {
        $status = sanitize_text_field( wp_unslash( $_GET['ltu_project_status_filter'] ) );
        if ( array_key_exists( $status, ltu_theme_project_status_choices() ) ) {
            $query->set( 'meta_query', [
                [
                    'key'   => 'status',
                    'value' => $status,
                ],
            ] );
        }
    }
}

add_action( 'restrict_manage_posts', 'ltu_theme_project_status_filter_dropdown' );
/**
 * Output a dropdown filter for project status in admin list.
 */
function ltu_theme_project_status_filter_dropdown( $post_type ) {
    if ( 'project' !== $post_type ) {
        return;
    }

    $current = isset( $_GET['ltu_project_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['ltu_project_status_filter'] ) ) : '';
    $choices = ltu_theme_project_status_choices();
    ?>
    <label for="ltu_project_status_filter" class="screen-reader-text"><?php esc_html_e( 'Filter by status', 'ltu-theme' ); ?></label>
    <select name="ltu_project_status_filter" id="ltu_project_status_filter">
        <option value=""><?php esc_html_e( 'All Statuses', 'ltu-theme' ); ?></option>
        <?php foreach ( $choices as $key => $label ) : ?>
            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current, $key ); ?>><?php echo esc_html( $label ); ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}
