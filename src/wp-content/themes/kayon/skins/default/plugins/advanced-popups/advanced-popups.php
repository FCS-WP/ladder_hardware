<?php

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'kayon_advanced_popups_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'kayon_advanced_popups_theme_setup9', 9 );
    function kayon_advanced_popups_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'kayon_filter_tgmpa_required_plugins', 'kayon_advanced_popups_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'kayon_advanced_popups_tgmpa_required_plugins' ) ) {    
    function kayon_advanced_popups_tgmpa_required_plugins( $list = array() ) {
        if ( kayon_storage_isset( 'required_plugins', 'advanced-popups' ) && kayon_storage_get_array( 'required_plugins', 'advanced-popups', 'install' ) !== false ) {
            $list[] = array(
                'name'     => kayon_storage_get_array( 'required_plugins', 'advanced-popups', 'title' ),
                'slug'     => 'advanced-popups',
                'required' => false,
            );
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( ! function_exists( 'kayon_exists_advanced_popups' ) ) {
    function kayon_exists_advanced_popups() {
        return function_exists('adp_init');
    }
}
