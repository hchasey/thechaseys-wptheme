<?php get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
    
    <nav class="nav-previous">
        <?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'thechaseys' ) . '</span> %title' ); ?>
    </nav>
    
	<?php $next_post = get_next_post(); if (!empty( $next_post )): ?>
        <nav class="nav-next">
            <?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'thechaseys' ) . '</span>' ); ?>
        </nav>
   <?php endif; ?> 

<?php get_footer(); ?>