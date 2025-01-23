<div class="front_page_section front_page_section_about<?php
	$kayon_scheme = kayon_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $kayon_scheme ) && ! kayon_is_inherit( $kayon_scheme ) ) {
		echo ' scheme_' . esc_attr( $kayon_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( kayon_get_theme_option( 'front_page_about_paddings' ) );
	if ( kayon_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$kayon_css      = '';
		$kayon_bg_image = kayon_get_theme_option( 'front_page_about_bg_image' );
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
	$kayon_anchor_icon = kayon_get_theme_option( 'front_page_about_anchor_icon' );
	$kayon_anchor_text = kayon_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $kayon_anchor_icon ) || ! empty( $kayon_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $kayon_anchor_icon ) ? ' icon="' . esc_attr( $kayon_anchor_icon ) . '"' : '' )
									. ( ! empty( $kayon_anchor_text ) ? ' title="' . esc_attr( $kayon_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( kayon_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' kayon-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$kayon_css           = '';
			$kayon_bg_mask       = kayon_get_theme_option( 'front_page_about_bg_mask' );
			$kayon_bg_color_type = kayon_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $kayon_bg_color_type ) {
				$kayon_bg_color = kayon_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$kayon_caption = kayon_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $kayon_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $kayon_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $kayon_caption, 'kayon_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$kayon_description = kayon_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $kayon_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $kayon_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $kayon_description ), 'kayon_kses_content' ); ?></div>
				<?php
			}

			// Content
			$kayon_content = kayon_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $kayon_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $kayon_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$kayon_page_content_mask = '%%CONTENT%%';
					if ( strpos( $kayon_content, $kayon_page_content_mask ) !== false ) {
						$kayon_content = preg_replace(
							'/(\<p\>\s*)?' . $kayon_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$kayon_content
						);
					}
					kayon_show_layout( $kayon_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
