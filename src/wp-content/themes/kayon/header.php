<?php
/**
 * The Header: Logo and main menu
 *
 * @package KAYON
 * @since KAYON 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( kayon_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'kayon_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'kayon_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('kayon_action_body_wrap_attributes'); ?>>

		<?php do_action( 'kayon_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'kayon_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('kayon_action_page_wrap_attributes'); ?>>

			<?php do_action( 'kayon_action_page_wrap_start' ); ?>

			<?php
			$kayon_full_post_loading = ( kayon_is_singular( 'post' ) || kayon_is_singular( 'attachment' ) ) && kayon_get_value_gp( 'action' ) == 'full_post_loading';
			$kayon_prev_post_loading = ( kayon_is_singular( 'post' ) || kayon_is_singular( 'attachment' ) ) && kayon_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $kayon_full_post_loading && ! $kayon_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="kayon_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'kayon_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'kayon' ); ?></a>
				<?php if ( kayon_sidebar_present() ) { ?>
				<a class="kayon_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'kayon_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'kayon' ); ?></a>
				<?php } ?>
				<a class="kayon_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'kayon_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'kayon' ); ?></a>

				<?php
				do_action( 'kayon_action_before_header' );

				// Header
				$kayon_header_type = kayon_get_theme_option( 'header_type' );
				if ( 'custom' == $kayon_header_type && ! kayon_is_layouts_available() ) {
					$kayon_header_type = 'default';
				}
				get_template_part( apply_filters( 'kayon_filter_get_template_part', "templates/header-" . sanitize_file_name( $kayon_header_type ) ) );

				// Side menu
				if ( in_array( kayon_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'kayon_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'kayon_action_after_header' );

			}
			?>

			<?php do_action( 'kayon_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( kayon_is_off( kayon_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $kayon_header_type ) ) {
						$kayon_header_type = kayon_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $kayon_header_type && kayon_is_layouts_available() ) {
						$kayon_header_id = kayon_get_custom_header_id();
						if ( $kayon_header_id > 0 ) {
							$kayon_header_meta = kayon_get_custom_layout_meta( $kayon_header_id );
							if ( ! empty( $kayon_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$kayon_footer_type = kayon_get_theme_option( 'footer_type' );
					if ( 'custom' == $kayon_footer_type && kayon_is_layouts_available() ) {
						$kayon_footer_id = kayon_get_custom_footer_id();
						if ( $kayon_footer_id ) {
							$kayon_footer_meta = kayon_get_custom_layout_meta( $kayon_footer_id );
							if ( ! empty( $kayon_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'kayon_action_page_content_wrap_class', $kayon_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'kayon_filter_is_prev_post_loading', $kayon_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( kayon_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'kayon_action_page_content_wrap_data', $kayon_prev_post_loading );
			?>>
				<?php
				do_action( 'kayon_action_page_content_wrap', $kayon_full_post_loading || $kayon_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'kayon_filter_single_post_header', kayon_is_singular( 'post' ) || kayon_is_singular( 'attachment' ) ) ) {
					if ( $kayon_prev_post_loading ) {
						if ( kayon_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'kayon_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$kayon_path = apply_filters( 'kayon_filter_get_template_part', 'templates/single-styles/' . kayon_get_theme_option( 'single_style' ) );
					if ( kayon_get_file_dir( $kayon_path . '.php' ) != '' ) {
						get_template_part( $kayon_path );
					}
				}

				// Widgets area above page
				$kayon_body_style   = kayon_get_theme_option( 'body_style' );
				$kayon_widgets_name = kayon_get_theme_option( 'widgets_above_page' );
				$kayon_show_widgets = ! kayon_is_off( $kayon_widgets_name ) && is_active_sidebar( $kayon_widgets_name );
				if ( $kayon_show_widgets ) {
					if ( 'fullscreen' != $kayon_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					kayon_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $kayon_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'kayon_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $kayon_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'kayon_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'kayon_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="kayon_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( kayon_is_singular( 'post' ) || kayon_is_singular( 'attachment' ) )
							&& $kayon_prev_post_loading 
							&& kayon_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'kayon_action_between_posts' );
						}

						// Widgets area above content
						kayon_create_widgets_area( 'widgets_above_content' );

						do_action( 'kayon_action_page_content_start_text' );
