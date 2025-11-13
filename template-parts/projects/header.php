<?php
/**
 * Projects listing header component.
 *
 * @package LTU-theme
 */

$title   = $args['title'] ?? '';
?>
<header class="projects-listing__header">
    <?php if ( $title ) : ?>
        <h1 class="projects-listing__title"><?php echo esc_html( $title ); ?></h1>
    <?php endif; ?>
</header>
