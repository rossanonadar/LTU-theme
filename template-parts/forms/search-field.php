<?php
/**
 * Generic search input component.
 *
 * @package LTU-theme
 */

$name        = $args['name'] ?? '';
$value       = $args['value'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$label       = $args['label'] ?? '';
$label_class = $args['label_class'] ?? 'screen-reader-text';
$class       = $args['class'] ?? '';
$id          = $args['id'] ?? $name;

if ( ! $name ) {
    return;
}
?>
<?php if ( $label ) : ?>
    <label for="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $label ); ?></label>
<?php endif; ?>
<input type="search" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo esc_attr( $value ); ?>">
