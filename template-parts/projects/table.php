<?php
/**
 * Projects table component.
 *
 * @package LTU-theme
 */

$projects       = $args['projects'] ?? null;
$status_choices = $args['status_choices'] ?? ltu_theme_project_status_choices();
$show_summary   = $args['show_summary'] ?? false;

if ( ! $projects instanceof WP_Query ) {
    return;
}
?>
<?php if ( $projects->have_posts() ) : ?>
    <div class="projects-listing__table-wrapper" data-projects-table>
        <table class="projects-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Project', 'ltu-theme' ); ?></th>
                    <th><?php esc_html_e( 'Client', 'ltu-theme' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'ltu-theme' ); ?></th>
                    <th><?php esc_html_e( 'Budget', 'ltu-theme' ); ?></th>
                    <th><?php esc_html_e( 'Start Date', 'ltu-theme' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rendered_budget = 0;
                while ( $projects->have_posts() ) :
                    $projects->the_post();
                    $client = get_post_meta( get_the_ID(), 'client_name', true );
                    $status = get_post_meta( get_the_ID(), 'status', true ) ?: 'planned';
                    $budget = get_post_meta( get_the_ID(), 'budget', true );
                    $date   = get_post_meta( get_the_ID(), 'start_date', true );

                    if ( '' !== $budget && null !== $budget ) {
                        $rendered_budget += (float) $budget;
                    }
                    ?>
                    <tr>
                        <td data-label="<?php esc_attr_e( 'Project', 'ltu-theme' ); ?>">
                            <a href="<?php the_permalink(); ?>" class="project-link" data-project-title><?php the_title(); ?></a>
                        </td>
                        <td data-label="<?php esc_attr_e( 'Client', 'ltu-theme' ); ?>" data-project-client><?php echo esc_html( $client ); ?></td>
                        <td data-label="<?php esc_attr_e( 'Status', 'ltu-theme' ); ?>" data-project-status="<?php echo esc_attr( $status ); ?>"><?php echo esc_html( $status_choices[ $status ] ?? ucfirst( $status ) ); ?></td>
                        <td data-label="<?php esc_attr_e( 'Budget', 'ltu-theme' ); ?>" data-project-budget="<?php echo esc_attr( $budget ); ?>">
                            <?php
                            if ( '' !== $budget && null !== $budget ) {
                                printf( '$%s', esc_html( number_format_i18n( floatval( $budget ), 2 ) ) );
                            }
                            ?>
                        </td>
                        <td data-label="<?php esc_attr_e( 'Start Date', 'ltu-theme' ); ?>" data-project-date="<?php echo esc_attr( $date ); ?>">
                            <?php
                            if ( $date ) {
                                echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) );
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                endwhile;
                ?>
            </tbody>
        </table>
        <?php if ( $show_summary ) : ?>
            <div class="projects-summary" data-projects-summary>
                <span><?php esc_html_e( 'Total budget:', 'ltu-theme' ); ?></span>
                <strong data-projects-total>
                    <?php echo esc_html( sprintf( '$%s', number_format_i18n( $rendered_budget, 2 ) ) ); ?>
                </strong>
            </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <p><?php esc_html_e( 'No projects found.', 'ltu-theme' ); ?></p>
<?php endif; ?>
