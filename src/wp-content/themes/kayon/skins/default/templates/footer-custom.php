<?php
/**
 * The template to display default site footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */

$kayon_footer_id = kayon_get_custom_footer_id();
$kayon_footer_meta = get_post_meta( $kayon_footer_id, 'trx_addons_options', true );
if ( ! empty( $kayon_footer_meta['margin'] ) ) {
	kayon_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( kayon_prepare_css_value( $kayon_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $kayon_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $kayon_footer_id ) ) ); ?>
						<?php
						$kayon_footer_scheme = kayon_get_theme_option( 'footer_scheme' );
						if ( ! empty( $kayon_footer_scheme ) && ! kayon_is_inherit( $kayon_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $kayon_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'kayon_action_show_layout', $kayon_footer_id );
	?>
</footer><!-- /.footer_wrap -->
