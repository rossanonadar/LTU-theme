<?php
/**
 * Front-end asset loading.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'ltu_theme_enqueue_assets' );
/**
 * Enqueue the built CSS and JS bundles produced by Webpack.
 */
function ltu_theme_enqueue_assets() {
    $style_path  = get_theme_file_path( 'assets/css/app.css' );
    $script_path = get_theme_file_path( 'assets/js/app.js' );

    if ( file_exists( $style_path ) ) { wp_enqueue_style('ltu-theme-app', get_theme_file_uri( 'assets/css/app.css' ), [],filemtime( $style_path ));
    }

    if ( file_exists( $script_path ) ) {wp_enqueue_script('ltu-theme-app', get_theme_file_uri( 'assets/js/app.js' ),[],filemtime( $script_path ),true);
    }
}
