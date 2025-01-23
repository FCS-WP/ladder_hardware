<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package KAYON
 * @since KAYON 1.0.10
 */

// Footer sidebar
$kayon_footer_name    = kayon_get_theme_option( 'footer_widgets' );
$kayon_footer_present = ! kayon_is_off( $kayon_footer_name ) && is_active_sidebar( $kayon_footer_name );
if ( $kayon_footer_present ) {
	kayon_storage_set( 'current_sidebar', 'footer' );
	$kayon_footer_wide = kayon_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $kayon_footer_name ) ) {
		dynamic_sidebar( $kayon_footer_name );
	}
	$kayon_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $kayon_out ) ) {
		$kayon_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $kayon_out );
		$kayon_need_columns = true;   //or check: strpos($kayon_out, 'columns_wrap')===false;
		if ( $kayon_need_columns ) {
			$kayon_columns = max( 0, (int) kayon_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $kayon_columns ) {
				$kayon_columns = min( 4, max( 1, kayon_tags_count( $kayon_out, 'aside' ) ) );
			}
			if ( $kayon_columns > 1 ) {
				$kayon_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $kayon_columns ) . ' widget', $kayon_out );
			} else {
				$kayon_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $kayon_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'kayon_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $kayon_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $kayon_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'kayon_action_before_sidebar', 'footer' );
				kayon_show_layout( $kayon_out );
				do_action( 'kayon_action_after_sidebar', 'footer' );
				if ( $kayon_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $kayon_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'kayon_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
