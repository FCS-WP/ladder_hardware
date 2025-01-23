<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package KAYON
 * @since KAYON 1.71.0
 */

$kayon_template_args = get_query_var( 'kayon_template_args' );
if ( ! is_array( $kayon_template_args ) ) {
	$kayon_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$kayon_columns       = 1;

$kayon_expanded      = ! kayon_sidebar_present() && kayon_get_theme_option( 'expand_content' ) == 'expand';

$kayon_post_format   = get_post_format();
$kayon_post_format   = empty( $kayon_post_format ) ? 'standard' : str_replace( 'post-format-', '', $kayon_post_format );

if ( is_array( $kayon_template_args ) ) {
	$kayon_columns    = empty( $kayon_template_args['columns'] ) ? 1 : max( 1, $kayon_template_args['columns'] );
	$kayon_blog_style = array( $kayon_template_args['type'], $kayon_columns );
	if ( ! empty( $kayon_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $kayon_columns > 1 ) {
	    $kayon_columns_class = kayon_get_column_class( 1, $kayon_columns, ! empty( $kayon_template_args['columns_tablet']) ? $kayon_template_args['columns_tablet'] : '', ! empty($kayon_template_args['columns_mobile']) ? $kayon_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $kayon_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $kayon_post_format ) );
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
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $kayon_template_args['thumb_size'] )
								? $kayon_template_args['thumb_size']
								: kayon_get_thumb_size( 
								in_array( $kayon_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $kayon_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$kayon_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$kayon_show_title = get_the_title() != '';
		$kayon_show_meta  = count( $kayon_components ) > 0 && ! in_array( $kayon_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $kayon_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'kayon_filter_show_blog_categories', $kayon_show_meta && in_array( 'categories', $kayon_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'kayon_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						kayon_show_post_meta( apply_filters(
															'kayon_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $kayon_hover, 1
															)
											);
						?>
					</div>
					<?php
					$kayon_components = kayon_array_delete_by_value( $kayon_components, 'categories' );
					do_action( 'kayon_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'kayon_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'kayon_action_before_post_title' );
					if ( empty( $kayon_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'kayon_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $kayon_template_args['excerpt_length'] ) && ! in_array( $kayon_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$kayon_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'kayon_filter_show_blog_excerpt', empty( $kayon_template_args['hide_excerpt'] ) && kayon_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				kayon_show_post_content( $kayon_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'kayon_filter_show_blog_meta', $kayon_show_meta, $kayon_components, 'band' ) ) {
			if ( count( $kayon_components ) > 0 ) {
				do_action( 'kayon_action_before_post_meta' );
				kayon_show_post_meta(
					apply_filters(
						'kayon_filter_post_meta_args', array(
							'components' => join( ',', $kayon_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'kayon_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'kayon_filter_show_blog_readmore', ! $kayon_show_title || ! empty( $kayon_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $kayon_template_args['no_links'] ) ) {
				do_action( 'kayon_action_before_post_readmore' );
				kayon_show_post_more_link( $kayon_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'kayon_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $kayon_template_args ) ) {
	if ( ! empty( $kayon_template_args['slider'] ) || $kayon_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
