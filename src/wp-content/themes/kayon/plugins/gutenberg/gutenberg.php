<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'kayon_gutenberg_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'kayon_gutenberg_theme_setup9', 9 );
	function kayon_gutenberg_theme_setup9() {

		// Add wide and full blocks support
		add_theme_support( 'align-wide' );

		// Add a block library styles support for the FSE themes
		if ( kayon_gutenberg_is_fse_theme() ) {
			add_theme_support( "wp-block-styles" );
		}

		// The theme supports responsive embedded content
		add_theme_support( "responsive-embeds" );

		// Add editor styles to backend
		add_theme_support( 'editor-styles' );
		if ( is_admin() && ( ! is_rtl() || ! is_customize_preview() ) ) {
			if ( kayon_exists_gutenberg() && kayon_gutenberg_is_preview() ) {
				if ( ! kayon_get_theme_setting( 'gutenberg_add_context' ) ) {
					if ( ! kayon_exists_trx_addons() ) {
						// Attention! This place need to use 'trx_addons_filter' instead 'kayon_filter'
						add_editor_style( apply_filters( 'trx_addons_filter_add_editor_style', array(), 'gutenberg' ) );
					}
				}
			} else {
				// Styles for TinyMCE
				add_editor_style( apply_filters( 'kayon_filter_add_editor_style', array(
					kayon_get_file_url( 'css/font-icons/css/fontello.css' ),
					kayon_get_file_url( 'css/__custom.css' ),
					kayon_get_file_url( 'css/editor-style.css' )
					), 'editor' )
				);
			}
		}

		if ( kayon_exists_gutenberg() ) {
			add_action( 'wp_enqueue_scripts', 'kayon_gutenberg_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'kayon_gutenberg_responsive_styles', 2000 );
			add_filter( 'kayon_filter_merge_styles', 'kayon_gutenberg_merge_styles' );
			add_filter( 'kayon_filter_merge_styles_responsive', 'kayon_gutenberg_merge_styles_responsive' );
		}
		add_action( 'enqueue_block_editor_assets', 'kayon_gutenberg_editor_scripts' );
		add_filter( 'kayon_filter_localize_script_admin',	'kayon_gutenberg_localize_script');
		add_action( 'after_setup_theme', 'kayon_gutenberg_add_editor_colors' );
		add_action( 'init', 'kayon_gutenberg_add_block_styles' );
		add_action( 'init', 'kayon_gutenberg_add_block_patterns' );
		if ( is_admin() ) {
			add_filter( 'kayon_filter_tgmpa_required_plugins', 'kayon_gutenberg_tgmpa_required_plugins' );
			add_filter( 'kayon_filter_theme_plugins', 'kayon_gutenberg_theme_plugins' );
		}
	}
}

// Add theme's icons styles to the Gutenberg editor
if ( ! function_exists( 'kayon_gutenberg_add_editor_style_icons' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'kayon_gutenberg_add_editor_style_icons', 10 );
	function kayon_gutenberg_add_editor_style_icons( $styles ) {
		$kayon_url = kayon_get_file_url( 'css/font-icons/css/fontello.css' );
		if ( '' != $kayon_url ) {
			$styles[] = $kayon_url;
		}
		return $styles;
	}
}

// Add required styles to the Gutenberg editor
if ( ! function_exists( 'kayon_gutenberg_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'kayon_gutenberg_add_editor_style', 1100 );
	function kayon_gutenberg_add_editor_style( $styles ) {
		$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' );
		if ( '' != $kayon_url ) {
			$styles[] = $kayon_url;
		}
		return $styles;
	}
}

// Add required styles to the Gutenberg editor
if ( ! function_exists( 'kayon_gutenberg_add_editor_style_responsive' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'kayon_gutenberg_add_editor_style_responsive', 2000 );
	function kayon_gutenberg_add_editor_style_responsive( $styles ) {
		$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg-preview-responsive.css' );
		if ( '' != $kayon_url ) {
			$styles[] = $kayon_url;
		}
		return $styles;
	}
}

// Add all skin-specific font-faces to the editor styles
if ( ! function_exists( 'kayon_gutenberg_add_editor_style_font_urls' ) ) {
	add_filter( 'kayon_filter_add_editor_style', 'kayon_gutenberg_add_editor_style_font_urls', 9990 );
	add_filter( 'trx_addons_filter_add_editor_style', 'kayon_gutenberg_add_editor_style_font_urls', 9990 );
	function kayon_gutenberg_add_editor_style_font_urls( $styles ) {
		return array_merge( $styles, kayon_theme_fonts_for_editor( true ) );
	}
}

// Remove main-theme and child-theme urls from the editor style paths
if ( ! function_exists( 'kayon_gutenberg_add_editor_style_remove_theme_url' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'kayon_gutenberg_add_editor_style_remove_theme_url', 9999 );
	function kayon_gutenberg_add_editor_style_remove_theme_url( $styles ) {
		if ( is_array( $styles ) ) {
			$template_uri   = trailingslashit( get_template_directory_uri() );
			$stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );
			$plugins_uri    = trailingslashit( defined( 'WP_PLUGIN_URL' ) ? WP_PLUGIN_URL : plugins_url() );
			$theme_replace  = '';
			$plugin_replace = '../'            // up to the folder 'themes'
								. '../'        // up to the folder 'wp-content'
								. 'plugins/';  // open the folder 'plugins'
			foreach( $styles as $k => $v ) {
				$styles[ $k ] = str_replace(
									array(
										$template_uri,
										strpos( $template_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $template_uri ) : $template_uri,
										$stylesheet_uri,
										strpos( $stylesheet_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $stylesheet_uri ) : $stylesheet_uri,
										$plugins_uri,
										strpos( $plugins_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $plugins_uri ) : $plugins_uri,
									),
									array(
										$theme_replace,
										$theme_replace,
										$theme_replace,
										$theme_replace,
										$plugin_replace,
										$plugin_replace,
									),
									$v
								);
			}
		}
		return $styles;
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'kayon_gutenberg_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('kayon_filter_tgmpa_required_plugins',	'kayon_gutenberg_tgmpa_required_plugins');
	function kayon_gutenberg_tgmpa_required_plugins( $list = array() ) {
		if ( kayon_storage_isset( 'required_plugins', 'gutenberg' ) ) {
			if ( kayon_storage_get_array( 'required_plugins', 'gutenberg', 'install' ) !== false && version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ) {
				$list[] = array(
					'name'     => kayon_storage_get_array( 'required_plugins', 'gutenberg', 'title' ),
					'slug'     => 'gutenberg',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'kayon_gutenberg_theme_plugins' ) ) {
	//Handler of the add_filter( 'kayon_filter_theme_plugins', 'kayon_gutenberg_theme_plugins' );
	function kayon_gutenberg_theme_plugins( $list = array() ) {
		$list = kayon_add_group_and_logo_to_slave( $list, 'gutenberg', 'coblocks' );
		$list = kayon_add_group_and_logo_to_slave( $list, 'gutenberg', 'kadence-blocks' );
		return $list;
	}
}


// Check if Gutenberg is installed and activated
if ( ! function_exists( 'kayon_exists_gutenberg' ) ) {
	function kayon_exists_gutenberg() {
		return function_exists( 'register_block_type' );
	}
}

// Return true if Gutenberg exists and current mode is preview
if ( ! function_exists( 'kayon_gutenberg_is_preview' ) ) {
	function kayon_gutenberg_is_preview() {
		return kayon_exists_gutenberg() 
				&& (
					kayon_gutenberg_is_block_render_action()
					||
					kayon_is_post_edit()
					||
					kayon_gutenberg_is_widgets_block_editor()
					||
					kayon_gutenberg_is_site_editor()
					);
	}
}

// Return true if current mode is "Full Site Editor"
if ( ! function_exists( 'kayon_gutenberg_is_site_editor' ) ) {
	function kayon_gutenberg_is_site_editor() {
		return is_admin()
				&& kayon_exists_gutenberg() 
				&& version_compare( get_bloginfo( 'version' ), '5.9', '>=' )
				&& kayon_check_url( 'site-editor.php' )
				&& kayon_gutenberg_is_fse_theme();
	}
}

// Return true if current mode is "Widgets Block Editor" (a new widgets panel with Gutenberg support)
if ( ! function_exists( 'kayon_gutenberg_is_widgets_block_editor' ) ) {
	function kayon_gutenberg_is_widgets_block_editor() {
		return is_admin()
				&& kayon_exists_gutenberg() 
				&& version_compare( get_bloginfo( 'version' ), '5.8', '>=' )
				&& kayon_check_url( 'widgets.php' )
				&& function_exists( 'wp_use_widgets_block_editor' )
				&& wp_use_widgets_block_editor();
	}
}

// Return true if current mode is "Block render"
if ( ! function_exists( 'kayon_gutenberg_is_block_render_action' ) ) {
	function kayon_gutenberg_is_block_render_action() {
		return kayon_exists_gutenberg() 
				&& kayon_check_url( 'block-renderer' ) && ! empty( $_GET['context'] ) && 'edit' == $_GET['context'];
	}
}

// Return true if content built with "Gutenberg"
if ( ! function_exists( 'kayon_gutenberg_is_content_built' ) ) {
	function kayon_gutenberg_is_content_built($content) {
		return kayon_exists_gutenberg() 
				&& has_blocks( $content );	// This condition is equval to: strpos($content, '<!-- wp:') !== false;
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'kayon_gutenberg_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'kayon_gutenberg_frontend_scripts', 1100 );
	function kayon_gutenberg_frontend_scripts() {
		if ( kayon_is_on( kayon_get_theme_option( 'debug_mode' ) ) ) {
			// Theme-specific styles
			$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg-general.css' );
			if ( '' != $kayon_url ) {
				wp_enqueue_style( 'kayon-gutenberg-general', $kayon_url, array(), null );
			}
			// Skin-specific styles
			$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg.css' );
			if ( '' != $kayon_url ) {
				wp_enqueue_style( 'kayon-gutenberg', $kayon_url, array(), null );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'kayon_gutenberg_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'kayon_gutenberg_responsive_styles', 2000 );
	function kayon_gutenberg_responsive_styles() {
		if ( kayon_is_on( kayon_get_theme_option( 'debug_mode' ) ) ) {
			// Theme-specific styles
			$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg-general-responsive.css' );
			if ( '' != $kayon_url ) {
				wp_enqueue_style( 'kayon-gutenberg-general-responsive', $kayon_url, array(), null, kayon_media_for_load_css_responsive( 'gutenberg-general' ) );
			}
			// Skin-specific styles
			$kayon_url = kayon_get_file_url( 'plugins/gutenberg/gutenberg-responsive.css' );
			if ( '' != $kayon_url ) {
				wp_enqueue_style( 'kayon-gutenberg-responsive', $kayon_url, array(), null, kayon_media_for_load_css_responsive( 'gutenberg' ) );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'kayon_gutenberg_merge_styles' ) ) {
	//Handler of the add_filter('kayon_filter_merge_styles', 'kayon_gutenberg_merge_styles');
	function kayon_gutenberg_merge_styles( $list ) {
		$list[ 'plugins/gutenberg/gutenberg-general.css' ] = true;
		$list[ 'plugins/gutenberg/gutenberg.css' ] = true;
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'kayon_gutenberg_merge_styles_responsive' ) ) {
	//Handler of the add_filter('kayon_filter_merge_styles_responsive', 'kayon_gutenberg_merge_styles_responsive');
	function kayon_gutenberg_merge_styles_responsive( $list ) {
		$list[ 'plugins/gutenberg/gutenberg-general-responsive.css' ] = true;
		$list[ 'plugins/gutenberg/gutenberg-responsive.css' ] = true;
		return $list;
	}
}


// Load required styles and scripts for Gutenberg Editor mode
if ( ! function_exists( 'kayon_gutenberg_editor_scripts' ) ) {
	//Handler of the add_action( 'enqueue_block_editor_assets', 'kayon_gutenberg_editor_scripts');
	function kayon_gutenberg_editor_scripts() {
		kayon_admin_scripts(true);
		kayon_admin_localize_scripts();
		// Editor styles
		wp_enqueue_style( 'kayon-gutenberg-editor', kayon_get_file_url( 'plugins/gutenberg/gutenberg-editor.css' ), array(), null );
		// Block styles
		if ( kayon_get_theme_setting( 'gutenberg_add_context' ) ) {
			wp_enqueue_style( 'kayon-gutenberg-preview', kayon_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' ), array(), null );
			wp_enqueue_style( 'kayon-gutenberg-preview-responsive', kayon_get_file_url( 'plugins/gutenberg/gutenberg-preview-responsive.css' ), array(), null );
		}
		// Load merged scripts ?????
		wp_enqueue_script( 'kayon-main', kayon_get_file_url( 'js/__scripts-full.js' ), apply_filters( 'kayon_filter_script_deps', array( 'jquery' ) ), null, true );
		// Editor scripts
		wp_enqueue_script( 'kayon-gutenberg-preview', kayon_get_file_url( 'plugins/gutenberg/gutenberg-preview.js' ), array( 'jquery' ), null, true );
	}
}

// Add plugin's specific variables to the scripts
if ( ! function_exists( 'kayon_gutenberg_localize_script' ) ) {
	//Handler of the add_filter( 'kayon_filter_localize_script_admin',	'kayon_gutenberg_localize_script');
	function kayon_gutenberg_localize_script( $arr ) {
		// Not overridden options
		$arr['color_scheme']     = kayon_get_theme_option( 'color_scheme' );
		// Overridden options
		$arr['override_classes'] = apply_filters( 'kayon_filter_override_options_list', array(
													'body_style'       => 'body_style_%s',
													'sidebar_position' => 'sidebar_position_%s',
													'expand_content'   => '%s_content'
									) );
		$post_id   = kayon_get_value_gpc( 'post' );
		$post_type = '';
		$post_slug = '';
		if ( kayon_gutenberg_is_preview() )  {
			if ( ! empty( $post_id ) ) {		// Edit post
				$post_type = kayon_get_edited_post_type();
				$meta = get_post_meta( $post_id, 'kayon_options', true );
			} else {							// New post
				$post_type = kayon_get_value_gpc( 'post_type' );
				if ( empty( $post_type ) ) {
					$post_type = 'post';
				}
			}
			if ( ! empty( $post_type ) ) {
				$post_slug = str_replace( 'cpt_', '', $post_type );
			}
		}
		foreach( $arr['override_classes'] as $opt => $class_mask ) {
			$arr[ $opt ] = 'inherit';
			if ( ! empty( $post_type ) ) {
				// Get an overridden value from the post meta
				if ( 'page' != $post_type && ! empty( $meta["{$opt}_single"] ) ) {
					$arr[ $opt ] = $meta["{$opt}_single"];
				} elseif ( 'page' == $post_type && ! empty( $meta[ $opt ] ) ) {
					$arr[ $opt ] = $meta[ $opt ];
				}
				// Get an overridden value from the theme options
				if ( 'inherit' == $arr[ $opt ] ) {
					if ( 'post' == $post_type ) {
						if ( kayon_check_theme_option( "{$opt}_single" ) ) {
							$arr[ $opt ] = kayon_get_theme_option( "{$opt}_single" );
						}
						if ( 'inherit' == $arr[ $opt ] && kayon_check_theme_option( "{$opt}_blog" ) ) {
							$arr[ $opt ] = kayon_get_theme_option( "{$opt}_blog" );
						}
					} else if ( 'page' != $post_type && kayon_check_theme_option( "{$opt}_single_" . sanitize_title( $post_slug ) ) ) {
						$arr[ $opt ] = kayon_get_theme_option( "{$opt}_single_" . sanitize_title( $post_slug ) );
						if ( 'inherit' == $arr[ $opt ] && kayon_check_theme_option( "{$opt}_" . sanitize_title( $post_slug ) ) ) {
							$arr[ $opt ] = kayon_get_theme_option( "{$opt}_" . sanitize_title( $post_slug ) );
						}
					}
				}
			}
			if ( 'inherit' == $arr[ $opt ] ) {
				$arr[ $opt ] = kayon_get_theme_option( $opt );
			}
		}
		return $arr;
	}
}

// Save CSS with custom colors and fonts to the gutenberg-preview.css
if ( ! function_exists( 'kayon_gutenberg_save_css' ) ) {
	add_action( 'kayon_action_save_options', 'kayon_gutenberg_save_css', 30 );
	add_action( 'trx_addons_action_save_options', 'kayon_gutenberg_save_css', 30 );
	function kayon_gutenberg_save_css() {

		$msg = '/* ' . esc_html__( "ATTENTION! This file was generated automatically! Don't change it!!!", 'kayon' )
				. "\n----------------------------------------------------------------------- */\n";

		$add_context = array(
							'context'      => '.edit-post-visual-editor ',
							'context_self' => array( 'html', 'body', '.edit-post-visual-editor' )
							);

		// Get main styles
		//----------------------------------------------
		$css = '';
		// Add styles from the theme style.css file is not recommended, because this file contains reset styles and it's can broke the editor styles
		if ( apply_filters( 'kayon_filter_add_style_css_to_gutenberg_preview', false ) ) {
			$css = kayon_fgc( kayon_get_file_dir( 'style.css' ) );
		}
		// Allow to add a skin-specific styles
		$css = apply_filters( 'kayon_filter_gutenberg_get_styles', $css );

		// Append single post styles
		if ( apply_filters( 'kayon_filters_separate_single_styles', false ) ) {
			$css .= kayon_fgc( kayon_get_file_dir( 'css/__single.css' ) );
		}
		// Append supported plugins styles
		$css .= kayon_fgc( kayon_get_file_dir( 'css/__plugins-full.css' ) );
		// Append theme-vars styles
		$css .= kayon_customizer_get_css();
		// Add context class to each selector
		if ( kayon_get_theme_setting( 'gutenberg_add_context' ) && function_exists( 'trx_addons_css_add_context' ) ) {
			$css = trx_addons_css_add_context( $css, $add_context );
		} else {
			$css = apply_filters( 'kayon_filter_prepare_css', $css );
		}

		// Get responsive styles
		//-----------------------------------------------
		$css_responsive = apply_filters( 'kayon_filter_gutenberg_get_styles_responsive',
								kayon_fgc( kayon_get_file_dir( 'css/__responsive-full.css' ) )
								. ( apply_filters( 'kayon_filters_separate_single_styles', false )
									? kayon_fgc( kayon_get_file_dir( 'css/__single-responsive.css' ) )
									: ''
									)
								);
		// Add context class to each selector
		if ( kayon_get_theme_setting( 'gutenberg_add_context' ) && function_exists( 'trx_addons_css_add_context' ) ) {
			$css_responsive = trx_addons_css_add_context( $css_responsive, $add_context );
		} else {
			$css_responsive = apply_filters( 'kayon_filter_prepare_css', $css_responsive );
		}

		// Save styles to separate files
		//-----------------------------------------------

		// Save responsive styles
		$preview = kayon_get_file_dir( 'plugins/gutenberg/gutenberg-preview-responsive.css' );
		if ( $preview ) {
			kayon_fpc( $preview, $msg . $css_responsive );
			$css_responsive = '';
		}
		// Save main styles (and append responsive if its not saved to the separate file)
		kayon_fpc( kayon_get_file_dir( 'plugins/gutenberg/gutenberg-preview.css' ), $msg . $css . $css_responsive );
	}
}


// Add theme-specific colors to the Gutenberg color picker
if ( ! function_exists( 'kayon_gutenberg_add_editor_colors' ) ) {
	//Handler of the add_action( 'after_setup_theme', 'kayon_gutenberg_add_editor_colors' );
	function kayon_gutenberg_add_editor_colors() {
		$scheme = kayon_get_scheme_colors();
		$groups = kayon_storage_get( 'scheme_color_groups' );
		$names  = kayon_storage_get( 'scheme_color_names' );
		$colors = array();
		foreach( $groups as $g => $group ) {
			foreach( $names as $n => $name ) {
				$c = 'main' == $g ? ( 'text' == $n ? 'text_color' : $n ) : $g . '_' . str_replace( 'text_', '', $n );
				if ( isset( $scheme[ $c ] ) ) {
					$colors[] = array(
						'slug'  => preg_replace( '/([a-z])([0-9])+/', '$1-$2', str_replace( '_', '-', $c ) ),
						'name'  => ( 'main' == $g ? '' : $group['title'] . ' ' ) . $name['title'],
						'color' => $scheme[ $c ]
					);
				}
			}
			// Add only one group of colors
			// Delete next condition (or add false && to them) to add all groups
			if ( 'main' == $g ) {
				break;
			}
		}
		add_theme_support( 'editor-color-palette', $colors );
	}
}


// Add theme-specific block styles for Gutenberg editor
if ( ! function_exists( 'kayon_gutenberg_add_block_styles' ) ) {
	//Handler of the add_action( 'init', 'kayon_gutenberg_add_block_styles' );
	function kayon_gutenberg_add_block_styles() {
		if ( kayon_get_theme_setting( 'add_gutenberg_block_styles' ) && function_exists( 'register_block_style' ) ) {
			$dir = kayon_get_file_dir( 'templates/block-styles' );
			if ( ! empty( $dir ) ) {
				$scheme = kayon_get_scheme_colors();
				$files = scandir( $dir );
				foreach( $files as $file ) {
					if ( in_array( $file, array( '.', '..' ) ) ) {
						continue;
					}
					$file = kayon_prepare_path( $dir . '/' . $file );
					if ( is_file( $file ) && pathinfo( $file, PATHINFO_EXTENSION ) == 'json' ) {
						$json = kayon_fgc( $file );
						if ( empty( $json ) ) {
							continue;
						}
						$data = json_decode( $json, true );
						if ( empty( $data ) ) {
							continue;
						}
						if ( ! empty( $data['block'] ) ) {
							$data = array( $data );
						}
						if ( is_array( $data ) ) {
							foreach( $data as $block ) {
								if ( is_array( $block ) && ! empty( $block['block'] ) && ! empty( $block['styles'] ) && is_array( $block['styles'] ) ) {
									foreach( $block['styles'] as $style ) {
										// Replace color names to the color values
										if ( ! empty( $style['inline_style'] ) ) {
											$style['inline_style'] = preg_replace_callback(
												'/%([a-z_]+)%/i',
												function( $match ) use ( $scheme ) {
													$color_name = kayon_get_scheme_color_name( $match[1] );
													return ( ! empty( $scheme[ $color_name ] ) )
														? $scheme[ $color_name ]
														: $match[0];
												},
												$style['inline_style']
											);
										}
										// Register block style
										register_block_style( $block['block'], $style );
									}
								}
							}
						}
					}
				}
			}
		}
	}
}


// Add theme-specific block patterns for Gutenberg editor
if ( ! function_exists( 'kayon_gutenberg_add_block_patterns' ) ) {
	//Handler of the add_action( 'init', 'kayon_gutenberg_add_block_patterns' );
	function kayon_gutenberg_add_block_patterns() {
		if ( kayon_get_theme_setting( 'add_gutenberg_block_patterns' ) && function_exists( 'register_block_pattern' ) ) {
			$dir = kayon_get_file_dir( 'templates/block-patterns' );
			if ( ! empty( $dir ) ) {
				$scheme = kayon_get_scheme_colors();
				$files = scandir( $dir );
				foreach( $files as $file ) {
					if ( in_array( $file, array( '.', '..' ) ) ) {
						continue;
					}
					$file = kayon_prepare_path( $dir . '/' . $file );
					if ( is_file( $file ) && pathinfo( $file, PATHINFO_EXTENSION ) == 'json' ) {
						$json = kayon_fgc( $file );
						if ( empty( $json ) ) {
							continue;
						}
						$data = json_decode( $json, true );
						if ( empty( $data ) ) {
							continue;
						}
						if ( ! empty( $data['name'] ) ) {
							$data = array( $data );
						}
						if ( is_array( $data ) ) {
							foreach( $data as $pattern ) {
								if ( is_array( $pattern ) && ! empty( $pattern['name'] ) && ! empty( $pattern['pattern'] ) && is_array( $pattern['pattern'] ) ) {
									foreach( $pattern['pattern'] as $pattern_data ) {
										// Register pattern
										register_block_pattern( $pattern['name'], $pattern_data );
									}
								}
							}
						}
					}
				}
			}
		}
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( kayon_exists_gutenberg() ) {
	$kayon_fdir = kayon_get_file_dir( 'plugins/gutenberg/gutenberg-style.php' );
	if ( ! empty( $kayon_fdir ) ) {
		require_once $kayon_fdir;
	}
	$kayon_fdir = kayon_get_file_dir( 'plugins/gutenberg/gutenberg-fse.php' );
	if ( ! empty( $kayon_fdir ) ) {
		require_once $kayon_fdir;
	}
}
