<?php
/**
 * The template to display the socials in the footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */


// Socials
if ( kayon_is_on( kayon_get_theme_option( 'socials_in_footer' ) ) ) {
	$kayon_output = kayon_get_socials_links();
	if ( '' != $kayon_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php kayon_show_layout( $kayon_output ); ?>
			</div>
		</div>
		<?php
	}
}
