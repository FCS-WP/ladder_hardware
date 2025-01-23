<?php
/**
 * The template to display default site footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$kayon_footer_scheme = kayon_get_theme_option( 'footer_scheme' );
if ( ! empty( $kayon_footer_scheme ) && ! kayon_is_inherit( $kayon_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $kayon_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
