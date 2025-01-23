<?php
/**
 * The template to display default site header
 *
 * @package KAYON
 * @since KAYON 1.0
 */

$kayon_header_css   = '';
$kayon_header_image = get_header_image();
$kayon_header_video = kayon_get_header_video();
if ( ! empty( $kayon_header_image ) && kayon_trx_addons_featured_image_override( is_singular() || kayon_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$kayon_header_image = kayon_get_current_mode_image( $kayon_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $kayon_header_image ) || ! empty( $kayon_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( kayon_is_on( kayon_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
