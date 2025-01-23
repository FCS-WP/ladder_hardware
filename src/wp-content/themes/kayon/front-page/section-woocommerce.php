<?php
$kayon_woocommerce_sc = kayon_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $kayon_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$kayon_scheme = kayon_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $kayon_scheme ) && ! kayon_is_inherit( $kayon_scheme ) ) {
			echo ' scheme_' . esc_attr( $kayon_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( kayon_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( kayon_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$kayon_css      = '';
			$kayon_bg_image = kayon_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$kayon_anchor_icon = kayon_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$kayon_anchor_text = kayon_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $kayon_anchor_icon ) || ! empty( $kayon_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $kayon_anchor_icon ) ? ' icon="' . esc_attr( $kayon_anchor_icon ) . '"' : '' )
											. ( ! empty( $kayon_anchor_text ) ? ' title="' . esc_attr( $kayon_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( kayon_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' kayon-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$kayon_css      = '';
				$kayon_bg_mask  = kayon_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$kayon_bg_color_type = kayon_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $kayon_bg_color_type ) {
					$kayon_bg_color = kayon_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$kayon_caption     = kayon_get_theme_option( 'front_page_woocommerce_caption' );
				$kayon_description = kayon_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $kayon_caption ) || ! empty( $kayon_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $kayon_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $kayon_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $kayon_caption, 'kayon_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $kayon_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $kayon_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $kayon_description ), 'kayon_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $kayon_woocommerce_sc ) {
						$kayon_woocommerce_sc_ids      = kayon_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$kayon_woocommerce_sc_per_page = count( explode( ',', $kayon_woocommerce_sc_ids ) );
					} else {
						$kayon_woocommerce_sc_per_page = max( 1, (int) kayon_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$kayon_woocommerce_sc_columns = max( 1, min( $kayon_woocommerce_sc_per_page, (int) kayon_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$kayon_woocommerce_sc}"
										. ( 'products' == $kayon_woocommerce_sc
												? ' ids="' . esc_attr( $kayon_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $kayon_woocommerce_sc
												? ' category="' . esc_attr( kayon_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $kayon_woocommerce_sc
												? ' orderby="' . esc_attr( kayon_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( kayon_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $kayon_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $kayon_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
