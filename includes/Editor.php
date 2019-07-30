<?php

namespace Wikilookup;

class Editor {
	public static function makePopupHTML( $title, $lang = null, $source = null, $content = '' ) {
		$nodeMaker = new NodeMaker();

		return $nodeMaker->makeNode(
			$content,
			[
				'data-wikilookup' => null,
				'data-wl-title' => $title,
				'data-wl-source' => $source,
				'data-wl-lang' => $lang,
				'data-wl-popup' => true,
			]
		);
	}

	public static function makeCardHTML( $title, $lang = null, $source = null, $content = '' ) {
		$nodeMaker = new NodeMaker();

		$term = $nodeMaker->makeNode(
			$content,
			[
				'data-wl-title' => $title,
				'data-wl-source' => $source,
				'data-wl-lang' => $lang,
				'data-wl-card' => true,
				'style' => 'display: none;'
			],
			'span',
			false
		);

		$panel = $nodeMaker->makeNode(
			'',
			[ 'class' => 'wl-card' ],
			'div',
			false
		);

		return $nodeMaker->wrap(
			[ $term, $panel ],
			[
				'class' => 'wl-card-wrapper'
			]
		);
	}

	public static function shortcodeWikipopup( $atts, $content = null ) {
		return self::makePopupHTML(
			Utils::getPropValue( $atts, 'title', $content ),
			Utils::getPropValue( $atts, 'lang', null ),
			Utils::getPropValue( $atts, 'source', null ),
			$content
		);
	}

	public static function shortcodeWikicard( $atts, $content = null ) {
		return self::makeCardHTML(
			Utils::getPropValue( $atts, 'title', $content ),
			Utils::getPropValue( $atts, 'lang', null ),
			Utils::getPropValue( $atts, 'source', null ),
			$content
		);
	}

	public static function registerGutenbergBlock() {
		// Skip block registration if Gutenberg is not enabled/merged.
		if ( !function_exists( 'register_block_type' ) ) {
			return;
		}
		$fileJS = 'assets/admin/editor/gutenberg.block.wikicard.js';
		wp_enqueue_script(
			'wikilookup-wikicard-gutenberg-block',
			WIKILOOKUP_DIR_URL . $fileJS,
			array(
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components',
				'jquery' // Wikilookup depends on jQuery; we need it for preview
			),
			filemtime( WIKILOOKUP_DIR_PATH . $fileJS )
		);

		// wikilookup
		wp_enqueue_script(
			'wikilookup-js-gutenberg',
			WIKILOOKUP_DIR_URL . 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.js',
			[ 'jquery' ],
			false,
			true // in footer
		);
		wp_enqueue_script(
			'wikilookup-js-gutenberg-process',
			WIKILOOKUP_DIR_URL . 'assets/admin/editor/gutenberg.editor.process.js',
			[ 'jquery' ],
			false,
			true // in footer
		);
		$jsVars = [
			'settings' => get_option( 'wikilookup_settings' ),
		];
		wp_localize_script( 'wikilookup-wikicard-gutenberg-block', 'wp_wikilookup_vars', $jsVars );

		wp_enqueue_style(
			'wikilookup-css-settings',
			WIKILOOKUP_DIR_URL . 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.css'
		);

		register_block_type( 'wikilookup/card', array(
			'editor_script' => 'wikilookup-wikicard-gutenberg-block',
			'render_callback' => 'Wikilookup\Editor::gutenbergCardBlockHandler',
			'attributes' => [
				'title' => [
					'type' => 'string',
				],
				'source' => [
					'default' => '',
					'type' => 'string',
				],
				'lang' => [
					'default' => 'en',
					'type' => 'string',
				],
			]
		));
	}

	public static function gutenbergCardBlockHandler( $atts ) {
		return self::makeCardHTML(
			Utils::getPropValue( $atts, 'title' ),
			Utils::getPropValue( $atts, 'lang', null ),
			Utils::getPropValue( $atts, 'source', null ),
			$title
		);
	}
}
/**
 * Register block
 */
