<?php
/**
 * Required plugins
 *
 * @package KAYON
 * @since KAYON 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$kayon_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'kayon' ),
	'page_builders' => esc_html__( 'Page Builders', 'kayon' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'kayon' ),
	'socials'       => esc_html__( 'Socials and Communities', 'kayon' ),
	'events'        => esc_html__( 'Events and Appointments', 'kayon' ),
	'content'       => esc_html__( 'Content', 'kayon' ),
	'other'         => esc_html__( 'Other', 'kayon' ),
);
$kayon_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'kayon' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'kayon' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $kayon_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'kayon' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'kayon' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $kayon_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'kayon' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'kayon' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $kayon_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'kayon' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'kayon' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $kayon_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'kayon' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'kayon' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $kayon_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'kayon' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'kayon' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $kayon_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'kayon' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'kayon' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $kayon_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'kayon' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'kayon' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $kayon_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $kayon_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $kayon_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'kayon' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $kayon_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'kayon' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'kayon' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => kayon_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $kayon_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'kayon' ),
		'description' => '',
		'required'    => false,
		'logo'        => kayon_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => kayon_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'kayon' ),
		'description' => '',
		'required'    => false,
		'logo'        => kayon_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $kayon_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => kayon_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $kayon_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => kayon_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'kayon' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'kayon' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'kayon' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'kayon' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $kayon_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'kayon' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'kayon' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $kayon_theme_required_plugins_groups['other'],
	),
	'gdpr-framework'         => array(
		'title'       => esc_html__( 'The GDPR Framework', 'kayon' ),
		'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'kayon' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'gdpr-framework.png',
		'group'       => $kayon_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'kayon' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'kayon' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $kayon_theme_required_plugins_groups['other'],
	),
);

if ( KAYON_THEME_FREE ) {
	unset( $kayon_theme_required_plugins['js_composer'] );
	unset( $kayon_theme_required_plugins['booked'] );
	unset( $kayon_theme_required_plugins['quickcal'] );
	unset( $kayon_theme_required_plugins['the-events-calendar'] );
	unset( $kayon_theme_required_plugins['calculated-fields-form'] );
	unset( $kayon_theme_required_plugins['essential-grid'] );
	unset( $kayon_theme_required_plugins['revslider'] );
	unset( $kayon_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $kayon_theme_required_plugins['trx_updater'] );
	unset( $kayon_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
kayon_storage_set( 'required_plugins', $kayon_theme_required_plugins );
