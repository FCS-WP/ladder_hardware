<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package KAYON
 * @since KAYON 1.0
 */

$kayon_template_args = get_query_var( 'kayon_template_args' );
$kayon_columns = 1;
if ( is_array( $kayon_template_args ) ) {
	$kayon_columns    = empty( $kayon_template_args['columns'] ) ? 1 : max( 1, $kayon_template_args['columns'] );
	$kayon_blog_style = array( $kayon_template_args['type'], $kayon_columns );
	if ( ! empty( $kayon_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $kayon_columns > 1 ) {
	    $kayon_columns_class = kayon_get_column_class( 1, $kayon_columns, ! empty( $kayon_template_args['columns_tablet']) ? $kayon_template_args['columns_tablet'] : '', ! empty($kayon_template_args['columns_mobile']) ? $kayon_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $kayon_columns_class ); ?>">
		<?php
	}
} else {
	$kayon_template_args = array();
}
$kayon_expanded    = ! kayon_sidebar_present() && kayon_get_theme_option( 'expand_content' ) == 'expand';
$kayon_post_format = get_post_format();
$kayon_post_format = empty( $kayon_post_format ) ? 'standard' : str_replace( 'post-format-', '', $kayon_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $kayon_post_format ) );
	kayon_add_blog_animation( $kayon_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$kayon_hover      = ! empty( $kayon_template_args['hover'] ) && ! kayon_is_inherit( $kayon_template_args['hover'] )
							? $kayon_template_args['hover']
							: kayon_get_theme_option( 'image_hover' );
	$kayon_components = ! empty( $kayon_template_args['meta_parts'] )
							? ( is_array( $kayon_template_args['meta_parts'] )
								? $kayon_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $kayon_template_args['meta_parts'] ) )
								)
							: kayon_array_get_keys_by_value( kayon_get_theme_option( 'meta_parts' ) );
	kayon_show_post_featured( apply_filters( 'kayon_filter_args_featured',
		array(
			'no_links'   => ! empty( $kayon_template_args['no_links'] ),
			'hover'      => $kayon_hover,
			'meta_parts' => $kayon_components,
			'thumb_size' => ! empty( $kayon_template_args['thumb_size'] )
							? $kayon_template_args['thumb_size']
							: kayon_get_thumb_size( strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $kayon_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$kayon_template_args
	) );

	// Title and post meta
	$kayon_show_title = get_the_title() != '';
	$kayon_show_meta  = count( $kayon_components ) > 0 && ! in_array( $kayon_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $kayon_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'kayon_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'kayon_action_before_post_title' );
				if ( empty( $kayon_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'kayon_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'kayon_filter_show_blog_excerpt', empty( $kayon_template_args['hide_excerpt'] ) && kayon_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'kayon_filter_show_blog_meta', $kayon_show_meta, $kayon_components, 'excerpt' ) ) {
				if ( count( $kayon_components ) > 0 ) {
					do_action( 'kayon_action_before_post_meta' );
					kayon_show_post_meta(
						apply_filters(
							'kayon_filter_post_meta_args', array(
								'components' => join( ',', $kayon_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'kayon_action_after_post_meta' );
				}
			}

			if ( kayon_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'kayon_action_before_full_post_content' );
					the_content( '' );
					do_action( 'kayon_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'kayon' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kayon' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				kayon_show_post_content( $kayon_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'kayon_filter_show_blog_readmore',  ! isset( $kayon_template_args['more_button'] ) || ! empty( $kayon_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $kayon_template_args['no_links'] ) ) {
					do_action( 'kayon_action_before_post_readmore' );
					if ( kayon_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						kayon_show_post_more_link( $kayon_template_args, '<p>', '</p>' );
					} else {
						kayon_show_post_comments_link( $kayon_template_args, '<p>', '</p>' );
					}
					do_action( 'kayon_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $kayon_template_args ) ) {
	if ( ! empty( $kayon_template_args['slider'] ) || $kayon_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
