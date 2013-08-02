<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>    

    <header class="entry-header">

        <h1 class="entry-title"><?php the_title(); ?></h1>

        <?php if ( comments_open() ) : ?>
            <div class="comments-link">
                <?php comments_popup_link( '<span class="leave-reply">' . __( 'comment', 'thechaseys' ) . '</span>', __( '1 comment', 'thechaseys' ), __( '% comments', 'thechaseys' ) ); ?>
            </div><!-- .comments-link -->
        <?php endif; // comments_open() ?>

    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'thechaseys' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'thechaseys' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php thechaseys_entry_meta(); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post -->
