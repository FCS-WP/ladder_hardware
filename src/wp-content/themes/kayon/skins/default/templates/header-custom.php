<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package KAYON
 * @since KAYON 1.0.06
 */

$kayon_header_css   = '';
$kayon_header_image = get_header_image();
$kayon_header_video = kayon_get_header_video();
if ( ! empty( $kayon_header_image ) && kayon_trx_addons_featured_image_override( is_singular() || kayon_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$kayon_header_image = kayon_get_current_mode_image( $kayon_header_image );
}

$kayon_header_id = kayon_get_custom_header_id();
$kayon_header_meta = get_post_meta( $kayon_header_id, 'trx_addons_options', true );
if ( ! empty( $kayon_header_meta['margin'] ) ) {
	kayon_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( kayon_prepare_css_value( $kayon_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $kayon_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $kayon_header_id ) ) ); ?>
				<?php
				echo ! empty( $kayon_header_image ) || ! empty( $kayon_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $kayon_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $kayon_header_image ) {
					echo ' ' . esc_attr( kayon_add_inline_css_class( 'background-image: url(' . esc_url( $kayon_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( kayon_is_on( kayon_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight kayon-full-height';
				}
				$kayon_header_scheme = kayon_get_theme_option( 'header_scheme' );
				if ( ! empty( $kayon_header_scheme ) && ! kayon_is_inherit( $kayon_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $kayon_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $kayon_header_video ) ) {
		get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'kayon_action_show_layout', $kayon_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
