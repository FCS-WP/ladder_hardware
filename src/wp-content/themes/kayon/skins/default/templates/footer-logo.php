<?php
/**
 * The template to display the site logo in the footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */

// Logo
if ( kayon_is_on( kayon_get_theme_option( 'logo_in_footer' ) ) ) {
	$kayon_logo_image = kayon_get_logo_image( 'footer' );
	$kayon_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $kayon_logo_image['logo'] ) || ! empty( $kayon_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $kayon_logo_image['logo'] ) ) {
					$kayon_attr = kayon_getimagesize( $kayon_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $kayon_logo_image['logo'] ) . '"'
								. ( ! empty( $kayon_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $kayon_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'kayon' ) . '"'
								. ( ! empty( $kayon_attr[3] ) ? ' ' . wp_kses_data( $kayon_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $kayon_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $kayon_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
