<?php
/**
 * The Portfolio template to display the content
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

$kayon_post_format = get_post_format();
$kayon_post_format = empty( $kayon_post_format ) ? 'standard' : str_replace( 'post-format-', '', $kayon_post_format );

?><div class="
<?php
if ( ! empty( $kayon_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( kayon_is_blog_style_use_masonry( $kayon_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $kayon_columns ) : esc_attr( $kayon_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $kayon_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $kayon_columns )
		. ( 'portfolio' != $kayon_blog_style[0] ? ' ' . esc_attr( $kayon_blog_style[0] )  . '_' . esc_attr( $kayon_columns ) : '' )
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

	$kayon_hover   = ! empty( $kayon_template_args['hover'] ) && ! kayon_is_inherit( $kayon_template_args['hover'] )
								? $kayon_template_args['hover']
								: kayon_get_theme_option( 'image_hover' );

	if ( 'dots' == $kayon_hover ) {
		$kayon_post_link = empty( $kayon_template_args['no_links'] )
								? ( ! empty( $kayon_template_args['link'] )
									? $kayon_template_args['link']
									: get_permalink()
									)
								: '';
		$kayon_target    = ! empty( $kayon_post_link ) && kayon_is_external_url( $kayon_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$kayon_components = ! empty( $kayon_template_args['meta_parts'] )
							? ( is_array( $kayon_template_args['meta_parts'] )
								? $kayon_template_args['meta_parts']
								: explode( ',', $kayon_template_args['meta_parts'] )
								)
							: kayon_array_get_keys_by_value( kayon_get_theme_option( 'meta_parts' ) );

	// Featured image
	kayon_show_post_featured( apply_filters( 'kayon_filter_args_featured',
        array(
			'hover'         => $kayon_hover,
			'no_links'      => ! empty( $kayon_template_args['no_links'] ),
			'thumb_size'    => ! empty( $kayon_template_args['thumb_size'] )
								? $kayon_template_args['thumb_size']
								: kayon_get_thumb_size(
									kayon_is_blog_style_use_masonry( $kayon_blog_style[0] )
										? (	strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false || $kayon_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( kayon_get_theme_option( 'body_style' ), 'full' ) !== false || $kayon_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => kayon_is_blog_style_use_masonry( $kayon_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $kayon_components,
			'class'         => 'dots' == $kayon_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $kayon_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $kayon_post_link )
												? '<a href="' . esc_url( $kayon_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $kayon_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $kayon_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $kayon_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!