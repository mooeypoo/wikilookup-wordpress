<?php
use PHPUnit\Framework\TestCase;

final class NodeMakerTest extends TestCase {

	public function testMakeNode() : void {
		$nodeMaker = new \Wikilookup\NodeMaker();

		$testCases = [
			[
				'content' => '',
				'attrs' => [],
				'expected' => '<span data-wikilookup=""></span>',
			],
			[
				'content' => 'foo',
				'attrs' => [ 'data-foo' => 'bar' ],
				'expected' => '<span data-wikilookup="" data-foo="bar">foo</span>',
			],
			[
				'content' => 'something with spaces',
				'attrs' => [],
				'expected' => '<span data-wikilookup="">something with spaces</span>',
			],
			[
				'content' => 'Foo',
				'attrs' => [ 'style' => 'width: 100%;', 'disabled' => 'disabled' ],
				'expected' => '<span data-wikilookup="" style="width: 100%;" disabled="disabled">Foo</span>',
			],
		];

		foreach ( $testCases as $case ) {
			$this->assertEquals(
				$nodeMaker->makeNode( $case['content'], $case['attrs'] ),
				$case['expected']
			);
		}
	}
}
