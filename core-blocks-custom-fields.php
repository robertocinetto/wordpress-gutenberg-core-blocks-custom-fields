<?php
/**
 * Plugin Name:       Core Blocks Custom Fields
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       core-blocks-custom-fields
 *
 * @package CreateBlock
 */


namespace core_blocks_custom_fields;

use WP_HTML_Tag_Processor;

/**
 * Enqueue specific modifications for the block editor.
 *
 * @return void
 */
function rc_enqueue_editor_modifications() {
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	wp_enqueue_script( 'core-blocks-custom-fields', plugin_dir_url( __FILE__ ) . 'build/index.js', $asset_file['dependencies'], $asset_file['version'], true );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\rc_enqueue_editor_modifications' );




/**
 * Filter button blocks for possible link attributes
 *
 * @param string $block_content The block content about to be rendered.
 * @param array  $block        The full block, including name and attributes.
 * @return string
 */
function filter_columns_block_render_block( $block_content, $block ) {

	if ( isset( $block['attrs']['reverseOnMobile'] ) && $block['attrs']['reverseOnMobile'] === true ) {
		$p = new WP_HTML_Tag_Processor( $block_content );
		if ( $p->next_tag( 'div', 1, 'wp-block-columns' ) ) {
			$p->add_class('reverse-on-mobile');
			$block_content = $p->get_updated_html();
		}
	}

	return $block_content;
}
add_filter( 'render_block_core/columns', __NAMESPACE__ . '\filter_columns_block_render_block', 10, 2 );