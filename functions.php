<?php

// Sets up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;

/* Sets up theme defaults and registers the various supported WordPress features
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 */
function thechaseys_setup() {
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );

	// This theme uses a custom image size for featured images, displayed on "standard" posts
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'thechaseys_setup' );

// Enqueues scripts and styles for front-end
function thechaseys_scripts_styles() {
	global $wp_styles;

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Loads main stylesheet
	wp_enqueue_style( 'thechaseys', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'thechaseys_scripts_styles' );

/* Creates a nicely formatted and more specific title element text for output in head of document, based on current view
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function thechaseys_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'thechaseys' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'thechaseys_wp_title', 10, 2 );

if ( ! function_exists( 'thechaseys_comment' ) ) :
// Template for comments and pingbacks. Used as a callback by wp_list_comments() for displaying the comments.
function thechaseys_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'thechaseys' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'thechaseys' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'thechaseys' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'thechaseys' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'thechaseys' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'thechaseys' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'thechaseys' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'thechaseys_entry_meta' ) ) :
// Prints HTML with meta information for current post: categories, tags, permalink, author, and date
function thechaseys_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'thechaseys' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'thechaseys' ) );

	$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author">%3$s</span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'thechaseys' ), get_the_author() ) ),
		get_the_author()
	);

	$utility_text = __( 'Posted on %3$s<span class="by-author"> by %4$s</span>.', 'thechaseys' );

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;