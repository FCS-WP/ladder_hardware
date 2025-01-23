<?php
/**
 * The template to display Admin notices
 *
 * @package KAYON
 * @since KAYON 1.0.1
 */

$kayon_theme_slug = get_option( 'template' );
$kayon_theme_obj  = wp_get_theme( $kayon_theme_slug );
?>
<div class="kayon_admin_notice kayon_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$kayon_theme_img = kayon_get_file_url( 'screenshot.jpg' );
	if ( '' != $kayon_theme_img ) {
		?>
		<div class="kayon_notice_image"><img src="<?php echo esc_url( $kayon_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'kayon' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="kayon_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'kayon' ),
				$kayon_theme_obj->get( 'Name' ) . ( KAYON_THEME_FREE ? ' ' . __( 'Free', 'kayon' ) : '' ),
				$kayon_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="kayon_notice_text">
		<p class="kayon_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $kayon_theme_obj->description ) );
			?>
		</p>
		<p class="kayon_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'kayon' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="kayon_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=kayon_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'kayon' );
			?>
		</a>
	</div>
</div>
