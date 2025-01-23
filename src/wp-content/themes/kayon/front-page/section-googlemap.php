<div class="front_page_section front_page_section_googlemap<?php
	$kayon_scheme = kayon_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $kayon_scheme ) && ! kayon_is_inherit( $kayon_scheme ) ) {
		echo ' scheme_' . esc_attr( $kayon_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( kayon_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( kayon_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$kayon_css      = '';
		$kayon_bg_image = kayon_get_theme_option( 'front_page_googlemap_bg_image' );
		if ( ! empty( $kayon_bg_image ) ) {
			$kayon_css .= 'background-image: url(' . esc_url( kayon_get_attachment_url( $kayon_bg_image ) ) . ');';
		}
		if ( ! empty( $kayon_css ) ) {
			echo ' style="' . esc_attr( $kayon_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$kayon_anchor_icon = kayon_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$kayon_anchor_text = kayon_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $kayon_anchor_icon ) || ! empty( $kayon_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $kayon_anchor_icon ) ? ' icon="' . esc_attr( $kayon_anchor_icon ) . '"' : '' )
									. ( ! empty( $kayon_anchor_text ) ? ' title="' . esc_attr( $kayon_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$kayon_layout = kayon_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $kayon_layout );
		if ( kayon_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' kayon-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$kayon_css      = '';
			$kayon_bg_mask  = kayon_get_theme_option( 'front_page_googlemap_bg_mask' );
			$kayon_bg_color_type = kayon_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $kayon_bg_color_type ) {
				$kayon_bg_color = kayon_get_theme_option( 'front_page_googlemap_bg_color' );
			} elseif ( 'scheme_bg_color' == $kayon_bg_color_type ) {
				$kayon_bg_color = kayon_get_scheme_color( 'bg_color', $kayon_scheme );
			} else {
				$kayon_bg_color = '';
			}
			if ( ! empty( $kayon_bg_color ) && $kayon_bg_mask > 0 ) {
				$kayon_css .= 'background-color: ' . esc_attr(
					1 == $kayon_bg_mask ? $kayon_bg_color : kayon_hex2rgba( $kayon_bg_color, $kayon_bg_mask )
				) . ';';
			}
			if ( ! empty( $kayon_css ) ) {
				echo ' style="' . esc_attr( $kayon_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $kayon_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$kayon_caption     = kayon_get_theme_option( 'front_page_googlemap_caption' );
			$kayon_description = kayon_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $kayon_caption ) || ! empty( $kayon_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $kayon_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $kayon_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $kayon_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $kayon_caption, 'kayon_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $kayon_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $kayon_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $kayon_description ), 'kayon_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $kayon_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$kayon_content = kayon_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $kayon_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $kayon_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $kayon_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $kayon_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $kayon_content, 'kayon_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $kayon_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $kayon_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! kayon_exists_trx_addons() ) {
						kayon_customizer_need_trx_addons_message();
					} else {
						kayon_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $kayon_layout && ( ! empty( $kayon_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
