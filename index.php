<?php  // Silence is golden.


global $wp_query;
get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', get_post_type() );
    endwhile;
else :
    get_template_part( 'template-parts/content', 'none' );
endif;

get_footer();

