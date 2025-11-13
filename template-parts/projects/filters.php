<?php
/**
 * Projects filters component.
 *
 * @package LTU-theme
 */

$status_choices  = $args['status_choices'] ?? [];
$selected_status = $args['selected_status'] ?? '';
$client_query    = $args['client_query'] ?? '';
$action_url      = $args['action_url'] ?? '';

$select_options = array_merge(
    [ '' => __( 'All Statuses', 'ltu-theme' ) ],
    $status_choices
);
?>
<form class="projects-filters" method="get" action="<?php echo esc_url( $action_url ?: get_permalink() ); ?>">
    <?php
        get_template_part('template-parts/forms/select-field', null,
            [
                'name'  => 'project_status',
                'id'    => 'project_status',
                'label' => __( 'Filter by status', 'ltu-theme' ),
                'options' => $select_options,
                'selected' => $selected_status,
                'class'  => 'projects-filters__control',
            ]
        );

        get_template_part('template-parts/forms/search-field', null,
            [
                'name'        => 'client_query',
                'id'          => 'client_query',
                'label'       => __( 'Search by client name', 'ltu-theme' ),
                'placeholder' => __( 'Search client…', 'ltu-theme' ),
                'value'       => $client_query,
                'class'       => 'projects-filters__control',
            ]
        );

        get_template_part('template-parts/forms/button', null,
            [
                'label' => __( 'Filter', 'ltu-theme' ),
                'class' => 'button button-primary projects-filters__submit',
            ]
        );

        get_template_part('template-parts/forms/link-button', null,
            [
                'label'     => __( 'Reset', 'ltu-theme' ),
                'url'       => $action_url ?: get_permalink(),
                'class'     => 'projects-filters__reset' . ( $selected_status || $client_query ? ' is-visible' : '' ),
                'attributes' => [ 'data-projects-reset' => '1' ],
            ]
        );
    ?>
</form>
