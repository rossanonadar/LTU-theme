<?php
/**
 * Generic link-style button component.
 *
 * @package LTU-theme
 */

$label      = $args['label'] ?? '';
$url        = $args['url'] ?? '';
$class      = $args['class'] ?? '';
$attributes = $args['attributes'] ?? [];

if ( ! $label || ! $url ) {
    return;
}

$attr_string = '';
foreach ( $attributes as $attr => $value ) {
    $attr_string .= sprintf( ' %s="%s"', esc_attr( $attr ), esc_attr( $value ) );
}
?>
<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $class ); ?>"<?php echo $attr_string; ?>><?php echo esc_html( $label ); ?></a>
