<?php
/**
 * Theme bootstrap for LTU Theme.
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

define( 'LTU_THEME_VERSION', '1.0.0' );

$ltu_theme_includes = [
    'inc/setup.php',
    'inc/assets.php',
    'inc/post-types/project.php',
    'inc/admin/project-meta-box.php',
    'inc/admin/project-list-table.php',
    'inc/api/projects.php',
];

foreach ( $ltu_theme_includes as $include ) {
    $filepath = get_theme_file_path( $include );

    if ( is_readable( $filepath ) ) {
        require_once $filepath;
    }
}
