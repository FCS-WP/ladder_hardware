<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package KAYON
 * @since KAYON 1.0
 */

$kayon_args = get_query_var( 'kayon_logo_args' );

// Site logo
$kayon_logo_type   = isset( $kayon_args['type'] ) ? $kayon_args['type'] : '';
$kayon_logo_image  = kayon_get_logo_image( $kayon_logo_type );
$kayon_logo_text   = kayon_is_on( kayon_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$kayon_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $kayon_logo_image['logo'] ) || ! empty( $kayon_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $kayon_logo_image['logo'] ) ) {
            if ( empty( $kayon_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($kayon_logo_image['logo']) && (int) $kayon_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$kayon_attr = kayon_getimagesize( $kayon_logo_image['logo'] );
				echo '<img src="' . esc_url( $kayon_logo_image['logo'] ) . '"'
						. ( ! empty( $kayon_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $kayon_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $kayon_logo_text ) . '"'
						. ( ! empty( $kayon_attr[3] ) ? ' ' . wp_kses_data( $kayon_attr[3] ) : '' )
						. '>';
			}
		} else {
			kayon_show_layout( kayon_prepare_macros( $kayon_logo_text ), '<span class="logo_text">', '</span>' );
			kayon_show_layout( kayon_prepare_macros( $kayon_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
