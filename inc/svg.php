<?php
/**
 * Media mime adjustments.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'upload_mimes', 'ltu_theme_enable_svg_uploads' );
/**
 * Permit SVG uploads for site admins.
 *
 * @param array $mimes Allowed mime types.
 *
 * @return array
 */
function ltu_theme_enable_svg_uploads( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['svg'] = 'image/svg+xml';
    }

    return $mimes;
}
