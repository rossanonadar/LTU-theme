<?php
/**
 * Header template for LTU Theme.
 *
 * @package LTU-theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="site-branding">
        <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'UTL home', 'ltu-theme' ); ?>">
            <span class="site-logo__mark" aria-hidden="true">UTL</span>
        </a>
    </div>
</header>
<main id="primary" class="site-main">
