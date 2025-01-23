<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package KAYON
 * @since KAYON 1.0
 */

// Page (category, tag, archive, author) title

if ( kayon_need_page_title() ) {
	kayon_sc_layouts_showed( 'title', true );
	kayon_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								kayon_show_post_meta(
									apply_filters(
										'kayon_filter_post_meta_args', array(
											'components' => join( ',', kayon_array_get_keys_by_value( kayon_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', kayon_array_get_keys_by_value( kayon_get_theme_option( 'counters' ) ) ),
											'seo'        => kayon_is_on( kayon_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$kayon_blog_title           = kayon_get_blog_title();
							$kayon_blog_title_text      = '';
							$kayon_blog_title_class     = '';
							$kayon_blog_title_link      = '';
							$kayon_blog_title_link_text = '';
							if ( is_array( $kayon_blog_title ) ) {
								$kayon_blog_title_text      = $kayon_blog_title['text'];
								$kayon_blog_title_class     = ! empty( $kayon_blog_title['class'] ) ? ' ' . $kayon_blog_title['class'] : '';
								$kayon_blog_title_link      = ! empty( $kayon_blog_title['link'] ) ? $kayon_blog_title['link'] : '';
								$kayon_blog_title_link_text = ! empty( $kayon_blog_title['link_text'] ) ? $kayon_blog_title['link_text'] : '';
							} else {
								$kayon_blog_title_text = $kayon_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $kayon_blog_title_class ); ?>">
								<?php
								$kayon_top_icon = kayon_get_term_image_small();
								if ( ! empty( $kayon_top_icon ) ) {
									$kayon_attr = kayon_getimagesize( $kayon_top_icon );
									?>
									<img src="<?php echo esc_url( $kayon_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'kayon' ); ?>"
										<?php
										if ( ! empty( $kayon_attr[3] ) ) {
											kayon_show_layout( $kayon_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $kayon_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $kayon_blog_title_link ) && ! empty( $kayon_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $kayon_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $kayon_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'kayon_action_breadcrumbs' );
						$kayon_breadcrumbs = ob_get_contents();
						ob_end_clean();
						kayon_show_layout( $kayon_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
