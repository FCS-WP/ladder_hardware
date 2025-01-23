<?php
/**
 * The template to display the background video in the header
 *
 * @package KAYON
 * @since KAYON 1.0.14
 */
$kayon_header_video = kayon_get_header_video();
$kayon_embed_video  = '';
if ( ! empty( $kayon_header_video ) && ! kayon_is_from_uploads( $kayon_header_video ) ) {
	if ( kayon_is_youtube_url( $kayon_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $kayon_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php kayon_show_layout( kayon_get_embed_video( $kayon_header_video ) ); ?></div>
		<?php
	}
}
