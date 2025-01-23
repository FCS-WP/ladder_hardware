<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$kayon_copyright_scheme = kayon_get_theme_option( 'copyright_scheme' );
if ( ! empty( $kayon_copyright_scheme ) && ! kayon_is_inherit( $kayon_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $kayon_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$kayon_copyright = kayon_get_theme_option( 'copyright' );
			if ( ! empty( $kayon_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$kayon_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $kayon_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$kayon_copyright = kayon_prepare_macros( $kayon_copyright );
				// Display copyright
				echo wp_kses( nl2br( $kayon_copyright ), 'kayon_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
