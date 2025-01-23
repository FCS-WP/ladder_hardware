<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package KAYON
 * @since KAYON 1.0
 */

$kayon_template_args = get_query_var( 'kayon_template_args' );

if ( is_array( $kayon_template_args ) ) {
	$kayon_columns    = empty( $kayon_template_args['columns'] ) ? 2 : max( 1, $kayon_template_args['columns'] );
	$kayon_blog_style = array( $kayon_template_args['type'], $kayon_columns );
    $kayon_columns_class = kayon_get_column_class( 1, $kayon_columns, ! empty( $kayon_template_args['columns_tablet']) ? $kayon_template_args['columns_tablet'] : '', ! empty($kayon_template_args['columns_mobile']) ? $kayon_template_args['columns_mobile'] : '' );
} else {
	$kayon_template_args = array();
	$kayon_blog_style = explode( '_', kayon_get_theme_option( 'blog_style' ) );
	$kayon_columns    = empty( $kayon_blog_style[1] ) ? 2 : max( 1, $kayon_blog_style[1] );
    $kayon_columns_class = kayon_get_column_class( 1, $kayon_columns );
}
$kayon_expanded   = ! kayon_sidebar_present() && kayon_get_theme_option( 'expand_content' ) == 'expand';

$kayon_post_format = get_post_format();
$kayon_post_format = empty( $kayon_post_format ) ? 'standard' : str_replace( 'post-format-', '', $kayon_post_format );

?><div class="<?php
	if ( ! empty( $kayon_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( kayon_is_blog_style_use_masonry( $kayon_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $kayon_columns ) : esc_attr( $kayon_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $kayon_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $kayon_columns )
				. ' post_layout_' . esc_attr( $kayon_blog_style[0] )
				. ' post_layout_' . esc_attr( $kayon_blog_style[0] ) . '_' . esc_attr( $kayon_columns )
	);
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
								: explode( ',', $kayon_template_args['meta_parts'] )
								)
							: kayon_array_get_keys_by_value( kayon_get_theme_option( 'meta_parts' ) );

	kayon_show_post_featured( apply_filters( 'kayon_filter_args_featured',
		array(
			'thumb_size' => ! empty( $kayon_template_args['thumb_size'] )
				? $kayon_template_args['thumb_size']
				: kayon_get_thumb_size(
				'classic' == $kayon_blog_style[0]
						? ( strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $kayon_columns > 2 ? 'big' : 'huge' )
								: ( $kayon_columns > 2
									? ( $kayon_expanded ? 'square' : 'square' )
									: ($kayon_columns > 1 ? 'square' : ( $kayon_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $kayon_columns > 2 ? 'masonry-big' : 'full' )
								: ($kayon_columns === 1 ? ( $kayon_expanded ? 'huge' : 'big' ) : ( $kayon_columns <= 2 && $kayon_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $kayon_hover,
			'meta_parts' => $kayon_components,
			'no_links'   => ! empty( $kayon_template_args['no_links'] ),
        ),
        'content-classic',
        $kayon_template_args
    ) );

	// Title and post meta
	$kayon_show_title = get_the_title() != '';
	$kayon_show_meta  = count( $kayon_components ) > 0 && ! in_array( $kayon_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $kayon_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'kayon_filter_show_blog_meta', $kayon_show_meta, $kayon_components, 'classic' ) ) {
				if ( count( $kayon_components ) > 0 ) {
					do_action( 'kayon_action_before_post_meta' );
					kayon_show_post_meta(
						apply_filters(
							'kayon_filter_post_meta_args', array(
							'components' => join( ',', $kayon_components ),
							'seo'        => false,
							'echo'       => true,
						), $kayon_blog_style[0], $kayon_columns
						)
					);
					do_action( 'kayon_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'kayon_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'kayon_action_before_post_title' );
				if ( empty( $kayon_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'kayon_action_after_post_title' );
			}

			if( !in_array( $kayon_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'kayon_filter_show_blog_readmore', ! $kayon_show_title || ! empty( $kayon_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $kayon_template_args['no_links'] ) ) {
						do_action( 'kayon_action_before_post_readmore' );
						kayon_show_post_more_link( $kayon_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'kayon_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $kayon_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('kayon_filter_show_blog_excerpt', empty($kayon_template_args['hide_excerpt']) && kayon_get_theme_option('excerpt_length') > 0, 'classic')) {
			kayon_show_post_content($kayon_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $kayon_template_args['more_button'] )) {
			if ( empty( $kayon_template_args['no_links'] ) ) {
				do_action( 'kayon_action_before_post_readmore' );
				kayon_show_post_more_link( $kayon_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'kayon_action_after_post_readmore' );
			}
		}
		$kayon_content = ob_get_contents();
		ob_end_clean();
		kayon_show_layout($kayon_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
