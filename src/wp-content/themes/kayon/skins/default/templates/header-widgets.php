<?php
/**
 * The template to display the widgets area in the header
 *
 * @package KAYON
 * @since KAYON 1.0
 */

// Header sidebar
$kayon_header_name    = kayon_get_theme_option( 'header_widgets' );
$kayon_header_present = ! kayon_is_off( $kayon_header_name ) && is_active_sidebar( $kayon_header_name );
if ( $kayon_header_present ) {
	kayon_storage_set( 'current_sidebar', 'header' );
	$kayon_header_wide = kayon_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $kayon_header_name ) ) {
		dynamic_sidebar( $kayon_header_name );
	}
	$kayon_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $kayon_widgets_output ) ) {
		$kayon_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $kayon_widgets_output );
		$kayon_need_columns   = strpos( $kayon_widgets_output, 'columns_wrap' ) === false;
		if ( $kayon_need_columns ) {
			$kayon_columns = max( 0, (int) kayon_get_theme_option( 'header_columns' ) );
			if ( 0 == $kayon_columns ) {
				$kayon_columns = min( 6, max( 1, kayon_tags_count( $kayon_widgets_output, 'aside' ) ) );
			}
			if ( $kayon_columns > 1 ) {
				$kayon_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $kayon_columns ) . ' widget', $kayon_widgets_output );
			} else {
				$kayon_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $kayon_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'kayon_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $kayon_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $kayon_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'kayon_action_before_sidebar', 'header' );
				kayon_show_layout( $kayon_widgets_output );
				do_action( 'kayon_action_after_sidebar', 'header' );
				if ( $kayon_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $kayon_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'kayon_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
