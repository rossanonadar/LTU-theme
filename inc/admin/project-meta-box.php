<?php
/**
 * Admin meta box for Project details.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes', 'ltu_theme_register_project_meta_box' );
/**
 * Register the Project Details meta box.
 */
function ltu_theme_register_project_meta_box() {
    add_meta_box(
        'ltu-project-details',
        __( 'Project Details', 'ltu-theme' ),
        'ltu_theme_render_project_meta_box',
        'project',
        'normal',
        'default'
    );
}

/**
 * Render the Project Details fields.
 */
function ltu_theme_render_project_meta_box( $post ) {
    wp_nonce_field( 'ltu_project_meta_save', 'ltu_project_meta_nonce' );

    $client_name = get_post_meta( $post->ID, 'client_name', true );
    $status      = get_post_meta( $post->ID, 'status', true ) ?: 'planned';
    $budget      = get_post_meta( $post->ID, 'budget', true );
    $start_date  = get_post_meta( $post->ID, 'start_date', true );
    $status_opts = ltu_theme_project_status_choices();
    ?>
    <div class="ltu-project-fields">
        <p>
            <label for="ltu_project_client_name"><strong><?php esc_html_e( 'Client Name', 'ltu-theme' ); ?></strong></label><br>
            <input type="text" id="ltu_project_client_name" name="ltu_project_client_name" class="widefat" value="<?php echo esc_attr( $client_name ); ?>">
        </p>
        <p>
            <label for="ltu_project_status"><strong><?php esc_html_e( 'Status', 'ltu-theme' ); ?></strong></label><br>
            <select id="ltu_project_status" name="ltu_project_status">
                <?php foreach ( $status_opts as $key => $label ) : ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="ltu_project_budget"><strong><?php esc_html_e( 'Budget', 'ltu-theme' ); ?></strong></label><br>
            <input type="number" step="0.01" min="0" id="ltu_project_budget" name="ltu_project_budget" value="<?php echo esc_attr( $budget ); ?>">
        </p>
        <p>
            <label for="ltu_project_start_date"><strong><?php esc_html_e( 'Start Date', 'ltu-theme' ); ?></strong></label><br>
            <input type="date" id="ltu_project_start_date" name="ltu_project_start_date" value="<?php echo esc_attr( $start_date ); ?>">
        </p>
    </div>
    <?php
}

add_action( 'save_post_project', 'ltu_theme_save_project_meta' );
/**
 * Persist the Project meta fields.
 */
function ltu_theme_save_project_meta( $post_id ) {
    if ( ! isset( $_POST['ltu_project_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ltu_project_meta_nonce'], 'ltu_project_meta_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = [
        'client_name' => isset( $_POST['ltu_project_client_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ltu_project_client_name'] ) ) : '',
        'status'      => isset( $_POST['ltu_project_status'] ) ? ltu_theme_sanitize_project_status( wp_unslash( $_POST['ltu_project_status'] ) ) : 'planned',
        'budget'      => isset( $_POST['ltu_project_budget'] ) && '' !== $_POST['ltu_project_budget'] ? ltu_theme_sanitize_project_budget( wp_unslash( $_POST['ltu_project_budget'] ) ) : '',
        'start_date'  => isset( $_POST['ltu_project_start_date'] ) ? ltu_theme_sanitize_project_date( wp_unslash( $_POST['ltu_project_start_date'] ) ) : '',
    ];

    foreach ( $fields as $key => $value ) {
        if ( '' === $value || null === $value ) {
            delete_post_meta( $post_id, $key );
            continue;
        }

        update_post_meta( $post_id, $key, $value );
    }
}
