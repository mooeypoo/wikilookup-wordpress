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
}
/**
 * Register block
 */
