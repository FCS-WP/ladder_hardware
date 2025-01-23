<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package KAYON
 * @since KAYON 1.0.50
 */

$kayon_template_args = get_query_var( 'kayon_template_args' );
if ( is_array( $kayon_template_args ) ) {
	$kayon_columns    = empty( $kayon_template_args['columns'] ) ? 2 : max( 1, $kayon_template_args['columns'] );
	$kayon_blog_style = array( $kayon_template_args['type'], $kayon_columns );
} else {
	$kayon_template_args = array();
	$kayon_blog_style = explode( '_', kayon_get_theme_option( 'blog_style' ) );
	$kayon_columns    = empty( $kayon_blog_style[1] ) ? 2 : max( 1, $kayon_blog_style[1] );
}
$kayon_blog_id       = kayon_get_custom_blog_id( join( '_', $kayon_blog_style ) );
$kayon_blog_style[0] = str_replace( 'blog-custom-', '', $kayon_blog_style[0] );
$kayon_expanded      = ! kayon_sidebar_present() && kayon_get_theme_option( 'expand_content' ) == 'expand';
$kayon_components    = ! empty( $kayon_template_args['meta_parts'] )
							? ( is_array( $kayon_template_args['meta_parts'] )
								? join( ',', $kayon_template_args['meta_parts'] )
								: $kayon_template_args['meta_parts']
								)
							: kayon_array_get_keys_by_value( kayon_get_theme_option( 'meta_parts' ) );
$kayon_post_format   = get_post_format();
$kayon_post_format   = empty( $kayon_post_format ) ? 'standard' : str_replace( 'post-format-', '', $kayon_post_format );

$kayon_blog_meta     = kayon_get_custom_layout_meta( $kayon_blog_id );
$kayon_custom_style  = ! empty( $kayon_blog_meta['scripts_required'] ) ? $kayon_blog_meta['scripts_required'] : 'none';

if ( ! empty( $kayon_template_args['slider'] ) || $kayon_columns > 1 || ! kayon_is_off( $kayon_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $kayon_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( kayon_is_off( $kayon_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $kayon_custom_style ) ) . "-1_{$kayon_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $kayon_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $kayon_columns )
					. ' post_layout_' . esc_attr( $kayon_blog_style[0] )
					. ' post_layout_' . esc_attr( $kayon_blog_style[0] ) . '_' . esc_attr( $kayon_columns )
					. ( ! kayon_is_off( $kayon_custom_style )
						? ' post_layout_' . esc_attr( $kayon_custom_style )
							. ' post_layout_' . esc_attr( $kayon_custom_style ) . '_' . esc_attr( $kayon_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'kayon_action_show_layout', $kayon_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $kayon_template_args['slider'] ) || $kayon_columns > 1 || ! kayon_is_off( $kayon_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
