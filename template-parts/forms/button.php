<?php
/**
 * Generic form button component.
 *
 * @package LTU-theme
 */

$label = $args['label'] ?? '';
$type  = $args['type'] ?? 'submit';
$class = $args['class'] ?? 'button';

if ( ! $label ) {
    return;
}
?>
<button type="<?php echo esc_attr( $type ); ?>" class="<?php echo esc_attr( $class ); ?>">
    <?php echo esc_html( $label ); ?>
</button>
