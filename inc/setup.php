<?php
/**
 * Theme setup hooks.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'ltu_theme_setup' );
/**
 * Configure default theme supports.
 */
function ltu_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

    register_nav_menus(
        [
            'primary' => __( 'Primary Menu', 'ltu-theme' ),
        ]
    );
}
