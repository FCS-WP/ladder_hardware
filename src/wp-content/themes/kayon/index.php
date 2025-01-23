<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package KAYON
 * @since KAYON 1.0
 */

$kayon_template = apply_filters( 'kayon_filter_get_template_part', kayon_blog_archive_get_template() );

if ( ! empty( $kayon_template ) && 'index' != $kayon_template ) {

	get_template_part( $kayon_template );

} else {

	kayon_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$kayon_stickies   = is_home()
								|| ( in_array( kayon_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) kayon_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$kayon_post_type  = kayon_get_theme_option( 'post_type' );
		$kayon_args       = array(
								'blog_style'     => kayon_get_theme_option( 'blog_style' ),
								'post_type'      => $kayon_post_type,
								'taxonomy'       => kayon_get_post_type_taxonomy( $kayon_post_type ),
								'parent_cat'     => kayon_get_theme_option( 'parent_cat' ),
								'posts_per_page' => kayon_get_theme_option( 'posts_per_page' ),
								'sticky'         => kayon_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $kayon_stickies )
															&& count( $kayon_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		kayon_blog_archive_start();

		do_action( 'kayon_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'kayon_action_before_page_author' );
			get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'kayon_action_after_page_author' );
		}

		if ( kayon_get_theme_option( 'show_filters' ) ) {
			do_action( 'kayon_action_before_page_filters' );
			kayon_show_filters( $kayon_args );
			do_action( 'kayon_action_after_page_filters' );
		} else {
			do_action( 'kayon_action_before_page_posts' );
			kayon_show_posts( array_merge( $kayon_args, array( 'cat' => $kayon_args['parent_cat'] ) ) );
			do_action( 'kayon_action_after_page_posts' );
		}

		do_action( 'kayon_action_blog_archive_end' );

		kayon_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
