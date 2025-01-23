<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package KAYON
 * @since KAYON 1.0
 */

							do_action( 'kayon_action_page_content_end_text' );
							
							// Widgets area below the content
							kayon_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'kayon_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'kayon_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'kayon_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'kayon_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$kayon_body_style = kayon_get_theme_option( 'body_style' );
					$kayon_widgets_name = kayon_get_theme_option( 'widgets_below_page' );
					$kayon_show_widgets = ! kayon_is_off( $kayon_widgets_name ) && is_active_sidebar( $kayon_widgets_name );
					$kayon_show_related = kayon_is_single() && kayon_get_theme_option( 'related_position' ) == 'below_page';
					if ( $kayon_show_widgets || $kayon_show_related ) {
						if ( 'fullscreen' != $kayon_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $kayon_show_related ) {
							do_action( 'kayon_action_related_posts' );
						}

						// Widgets area below page content
						if ( $kayon_show_widgets ) {
							kayon_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $kayon_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'kayon_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'kayon_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! kayon_is_singular( 'post' ) && ! kayon_is_singular( 'attachment' ) ) || ! in_array ( kayon_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="kayon_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'kayon_action_before_footer' );

				// Footer
				$kayon_footer_type = kayon_get_theme_option( 'footer_type' );
				if ( 'custom' == $kayon_footer_type && ! kayon_is_layouts_available() ) {
					$kayon_footer_type = 'default';
				}
				get_template_part( apply_filters( 'kayon_filter_get_template_part', "templates/footer-" . sanitize_file_name( $kayon_footer_type ) ) );

				do_action( 'kayon_action_after_footer' );

			}
			?>

			<?php do_action( 'kayon_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'kayon_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'kayon_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>