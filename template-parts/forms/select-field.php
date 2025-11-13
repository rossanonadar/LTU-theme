<?php
/**
 * Generic select field component.
 *
 * @package LTU-theme
 */

$name        = $args['name'] ?? '';
$options     = $args['options'] ?? [];
$selected    = $args['selected'] ?? '';
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
<select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
    <?php foreach ( $options as $value => $text ) : ?>
        <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected, $value ); ?>><?php echo esc_html( $text ); ?></option>
    <?php endforeach; ?>
</select>
