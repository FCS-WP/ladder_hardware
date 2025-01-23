<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package KAYON
 * @since KAYON 1.0
 */

if ( kayon_sidebar_present() ) {
	
	$kayon_sidebar_type = kayon_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $kayon_sidebar_type && ! kayon_is_layouts_available() ) {
		$kayon_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $kayon_sidebar_type ) {
		// Default sidebar with widgets
		$kayon_sidebar_name = kayon_get_theme_option( 'sidebar_widgets' );
		kayon_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $kayon_sidebar_name ) ) {
			dynamic_sidebar( $kayon_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$kayon_sidebar_id = kayon_get_custom_sidebar_id();
		do_action( 'kayon_action_show_layout', $kayon_sidebar_id );
	}
	$kayon_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $kayon_out ) ) {
		$kayon_sidebar_position    = kayon_get_theme_option( 'sidebar_position' );
		$kayon_sidebar_position_ss = kayon_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $kayon_sidebar_position );
			echo ' sidebar_' . esc_attr( $kayon_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $kayon_sidebar_type );

			$kayon_sidebar_scheme = apply_filters( 'kayon_filter_sidebar_scheme', kayon_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $kayon_sidebar_scheme ) && ! kayon_is_inherit( $kayon_sidebar_scheme ) && 'custom' != $kayon_sidebar_type ) {
				echo ' scheme_' . esc_attr( $kayon_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="kayon_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'kayon_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $kayon_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$kayon_title = apply_filters( 'kayon_filter_sidebar_control_title', 'float' == $kayon_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'kayon' ) : '' );
				$kayon_text  = apply_filters( 'kayon_filter_sidebar_control_text', 'above' == $kayon_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'kayon' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $kayon_title ); ?>"><?php echo esc_html( $kayon_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'kayon_action_before_sidebar', 'sidebar' );
				kayon_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $kayon_out ) );
				do_action( 'kayon_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'kayon_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
