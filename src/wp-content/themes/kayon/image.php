<?php
/**
 * The template to display the attachment
 *
 * @package KAYON
 * @since KAYON 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/content', 'single-' . kayon_get_theme_option( 'single_style' ) ), 'single-' . kayon_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$kayon_posts_navigation = kayon_get_theme_option( 'posts_navigation' );
	if ( 'links' == $kayon_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! kayon_is_off( kayon_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'kayon_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'kayon' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'kayon' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'kayon_action_before_comments' );
	comments_template();
	do_action( 'kayon_action_after_comments' );
}

get_footer();
