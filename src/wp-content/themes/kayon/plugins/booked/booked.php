<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'kayon_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'kayon_booked_theme_setup9', 9 );
	function kayon_booked_theme_setup9() {
		if ( kayon_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'kayon_booked_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'kayon_booked_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'kayon_booked_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'kayon_booked_frontend_scripts_responsive', 10, 1 );
			add_filter( 'kayon_filter_merge_styles', 'kayon_booked_merge_styles' );
			add_filter( 'kayon_filter_merge_styles_responsive', 'kayon_booked_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'kayon_filter_tgmpa_required_plugins', 'kayon_booked_tgmpa_required_plugins' );
			add_filter( 'kayon_filter_theme_plugins', 'kayon_booked_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'kayon_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('kayon_filter_tgmpa_required_plugins',	'kayon_booked_tgmpa_required_plugins');
	function kayon_booked_tgmpa_required_plugins( $list = array() ) {
		if ( kayon_storage_isset( 'required_plugins', 'booked' ) && kayon_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && kayon_is_theme_activated() ) {
			$path = kayon_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || kayon_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => kayon_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.4.3.1',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'kayon_booked_theme_plugins' ) ) {
	//Handler of the add_filter( 'kayon_filter_theme_plugins', 'kayon_booked_theme_plugins' );
	function kayon_booked_theme_plugins( $list = array() ) {
		return kayon_add_group_and_logo_to_slave( $list, 'booked', 'booked-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'kayon_exists_booked' ) ) {
	function kayon_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Return a relative path to the plugin styles depend the version
if ( ! function_exists( 'kayon_booked_get_styles_dir' ) ) {
	function kayon_booked_get_styles_dir( $file ) {
		$base_dir = 'plugins/booked/';
		return $base_dir
				. ( defined( 'BOOKED_VERSION' ) && version_compare( BOOKED_VERSION, '2.4', '<' ) && kayon_get_folder_dir( $base_dir . 'old' )
					? 'old/'
					: ''
					)
				. $file;
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'kayon_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'kayon_booked_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'kayon_booked_frontend_scripts', 10, 1 );
	function kayon_booked_frontend_scripts( $force = false ) {
		kayon_enqueue_optimized( 'booked', $force, array(
			'css' => array(
				'kayon-booked' => array( 'src' => kayon_booked_get_styles_dir( 'booked.css' ) ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'kayon_booked_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'kayon_booked_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'kayon_booked_frontend_scripts_responsive', 10, 1 );
	function kayon_booked_frontend_scripts_responsive( $force = false ) {
		kayon_enqueue_optimized_responsive( 'booked', $force, array(
			'css' => array(
				'kayon-booked-responsive' => array( 'src' => kayon_booked_get_styles_dir( 'booked-responsive.css' ), 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'kayon_booked_merge_styles' ) ) {
	//Handler of the add_filter('kayon_filter_merge_styles', 'kayon_booked_merge_styles');
	function kayon_booked_merge_styles( $list ) {
		$list[ kayon_booked_get_styles_dir( 'booked.css' ) ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'kayon_booked_merge_styles_responsive' ) ) {
	//Handler of the add_filter('kayon_filter_merge_styles_responsive', 'kayon_booked_merge_styles_responsive');
	function kayon_booked_merge_styles_responsive( $list ) {
		$list[ kayon_booked_get_styles_dir( 'booked-responsive.css' ) ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( kayon_exists_booked() ) {
	$kayon_fdir = kayon_get_file_dir( kayon_booked_get_styles_dir( 'booked-style.php' ) );
	if ( ! empty( $kayon_fdir ) ) {
		require_once $kayon_fdir;
	}
}
