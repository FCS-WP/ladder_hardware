<?php
/**
 * The template to display single post
 *
 * @package KAYON
 * @since KAYON 1.0
 */

// Full post loading
$full_post_loading          = kayon_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = kayon_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = kayon_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$kayon_related_position   = kayon_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$kayon_posts_navigation   = kayon_get_theme_option( 'posts_navigation' );
$kayon_prev_post          = false;
$kayon_prev_post_same_cat = kayon_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( kayon_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	kayon_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'kayon_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $kayon_posts_navigation ) {
		$kayon_prev_post = get_previous_post( $kayon_prev_post_same_cat );  // Get post from same category
		if ( ! $kayon_prev_post && $kayon_prev_post_same_cat ) {
			$kayon_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $kayon_prev_post ) {
			$kayon_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $kayon_prev_post ) ) {
		kayon_sc_layouts_showed( 'featured', false );
		kayon_sc_layouts_showed( 'title', false );
		kayon_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $kayon_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/content', 'single-' . kayon_get_theme_option( 'single_style' ) ), 'single-' . kayon_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $kayon_related_position, 'inside' ) === 0 ) {
		$kayon_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'kayon_action_related_posts' );
		$kayon_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $kayon_related_content ) ) {
			$kayon_related_position_inside = max( 0, min( 9, kayon_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $kayon_related_position_inside ) {
				$kayon_related_position_inside = mt_rand( 1, 9 );
			}

			$kayon_p_number         = 0;
			$kayon_related_inserted = false;
			$kayon_in_block         = false;
			$kayon_content_start    = strpos( $kayon_content, '<div class="post_content' );
			$kayon_content_end      = strrpos( $kayon_content, '</div>' );

			for ( $i = max( 0, $kayon_content_start ); $i < min( strlen( $kayon_content ) - 3, $kayon_content_end ); $i++ ) {
				if ( $kayon_content[ $i ] != '<' ) {
					continue;
				}
				if ( $kayon_in_block ) {
					if ( strtolower( substr( $kayon_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$kayon_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $kayon_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $kayon_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$kayon_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $kayon_content[ $i + 1 ] && in_array( $kayon_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$kayon_p_number++;
					if ( $kayon_related_position_inside == $kayon_p_number ) {
						$kayon_related_inserted = true;
						$kayon_content = ( $i > 0 ? substr( $kayon_content, 0, $i ) : '' )
											. $kayon_related_content
											. substr( $kayon_content, $i );
					}
				}
			}
			if ( ! $kayon_related_inserted ) {
				if ( $kayon_content_end > 0 ) {
					$kayon_content = substr( $kayon_content, 0, $kayon_content_end ) . $kayon_related_content . substr( $kayon_content, $kayon_content_end );
				} else {
					$kayon_content .= $kayon_related_content;
				}
			}
		}

		kayon_show_layout( $kayon_content );
	}

	// Comments
	do_action( 'kayon_action_before_comments' );
	comments_template();
	do_action( 'kayon_action_after_comments' );

	// Related posts
	if ( 'below_content' == $kayon_related_position
		&& ( 'scroll' != $kayon_posts_navigation || kayon_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || kayon_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'kayon_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $kayon_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $kayon_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $kayon_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $kayon_prev_post ) ); ?>"
			<?php do_action( 'kayon_action_nav_links_single_scroll_data', $kayon_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
