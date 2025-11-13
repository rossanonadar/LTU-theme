<?php
/**
 * Template for displaying single Project posts.
 *
 * @package LTU-theme
 */

global $post;

get_header();
?>
<section class="project-single">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post();
            $client = get_post_meta( get_the_ID(), 'client_name', true );
            $status = get_post_meta( get_the_ID(), 'status', true ) ?: 'planned';
            $budget = get_post_meta( get_the_ID(), 'budget', true );
            $date   = get_post_meta( get_the_ID(), 'start_date', true );
            $status_choices = ltu_theme_project_status_choices();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'project-single__card' ); ?>>
            <header class="project-single__header">
                <p class="project-single__eyebrow"><?php esc_html_e( 'Project', 'ltu-theme' ); ?></p>
                <h1 class="project-single__title"><?php the_title(); ?></h1>
                <span class="project-single__status project-single__status--<?php echo esc_attr( $status ); ?>">
                    <?php echo esc_html( $status_choices[ $status ] ?? ucfirst( $status ) ); ?>
                </span>
            </header>

            <dl class="project-single__meta">
                <?php if ( $client ) : ?>
                    <div>
                        <dt><?php esc_html_e( 'Client', 'ltu-theme' ); ?></dt>
                        <dd><?php echo esc_html( $client ); ?></dd>
                    </div>
                <?php endif; ?>

                <?php if ( '' !== $budget && null !== $budget ) : ?>
                    <div>
                        <dt><?php esc_html_e( 'Budget', 'ltu-theme' ); ?></dt>
                        <dd><?php printf( '$%s', esc_html( number_format_i18n( floatval( $budget ), 2 ) ) ); ?></dd>
                    </div>
                <?php endif; ?>

                <?php if ( $date ) : ?>
                    <div>
                        <dt><?php esc_html_e( 'Start Date', 'ltu-theme' ); ?></dt>
                        <dd><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ); ?></dd>
                    </div>
                <?php endif; ?>
            </dl>

            <div class="project-single__content entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Project not found.', 'ltu-theme' ); ?></p>
    <?php endif; ?>
</section>
<?php
get_footer();
