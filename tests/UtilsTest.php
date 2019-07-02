<?php
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase {

	public function testGetIfExists() : void {
		$testCases = [
			[
				// straight forward
				'arr' => [ 'foo' => 'bar' ],
				'prop' => 'foo',
				'default' => null,
				'expected' => 'bar',
			],
			[
				// nonexistent
				'arr' => [ 'foo' => 'bar' ],
				'prop' => 'blip',
				'default' => null,
				'expected' => null,
			],
			[
				// nonexistent with default
				'arr' => [ 'foo' => 'bar' ],
				'prop' => 'blip',
				'default' => 'default value',
				'expected' => 'default value',
			],
			[
				// empty array
				'arr' => [],
				'prop' => 'blip',
				'default' => null,
				'expected' => null,
			],
		];

		foreach ( $testCases as $case ) {
			$this->assertEquals(
				\Wikilookup\Utils::getIfExists(
					$case['arr'], $case['prop'], $case['default']
				),
				$case['expected']
			);
		}
	}

	public function testGetPropsValue() : void {
		$testCases = [
			[
				// straight forward
				'arr' => [ 'foo' => 'bar' ],
				'props' => [ 'foo' ],
				'default' => null,
				'expected' => 'bar',
				'msg' => 'Straight forward lookup',
			],
			[
				// deep prop
				'arr' => [ 'foo' => [ 'bar' => [ 'baz' => [ 'quuz' => 'final' ], 'baz2' => 'blah' ] ] ],
				'props' => [ 'foo', 'bar', 'baz', 'quuz' ],
				'default' => null,
				'expected' => 'final',
				'msg' => 'Deep lookup',
			],
			[
				// nonexistent prop; deep
				'arr' => [ 'foo' => [ 'bar' => [ 'baz' => [ 'quuz' => 'final' ], 'baz2' => 'blah' ] ] ],
				'props' => [ 'foo', 'bar', 'baz', 'nonexistent' ],
				'default' => null,
				'expected' => null,
				'msg' => 'Nonexistent prop, deep lookup',
			],
			[
				// nonexistent prop; deep; with default
				'arr' => [ 'foo' => [ 'bar' => [ 'baz' => [ 'quuz' => 'final' ], 'baz2' => 'blah' ] ] ],
				'props' => [ 'foo', 'bar', 'baz', 'nonexistent' ],
				'default' => 'default',
				'expected' => 'default',
				'msg' => 'Nonexistent prop, deep lookup, with default value',
			],
		];

		foreach ( $testCases as $case ) {
			$this->assertEquals(
				\Wikilookup\Utils::getPropValue(
					$case['arr'], $case['props'], $case['default']
				),
				$case['expected']
			);
		}
	}
}
