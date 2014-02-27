<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for Li3 applications
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\util;

use li3_enhance\util\Set;

/**
 * @package li3_enhance
 */
class SetTest extends \lithium\test\Unit
{

    public function setUp()
    {
        $this->recursiveArray = array(
            'apple',
            'orange',
            'banana',
            'juice' => array(
                'strawberry',
                'lemon' => array(
                    'pulp'
                )
            )
        );
        $this->dataArray = array(
            array('id' => 0, 'item' => array('name' => 'Apple')),
            array('id' => 3, 'item' => array('name' => 'Orange')),
            array('id' => 1, 'item' => array('name' => 'Banana')),
            array('id' => 2, 'item' => array('name' => 'Strawberry')),
            array('id' => 6, 'item' => array('name' => 'Lemon'))
        );
    }

    public function testInArrayRecursive()
    {
        $this->assertTrue(Set::inArrayRecursive('pulp', $this->recursiveArray));
        $this->assertTrue(Set::inArrayRecursive('orange', $this->recursiveArray));
    }

    public function testInArrayRecursiveNotFound()
    {
        $this->assertFalse(Set::inArrayRecursive('pizza', $this->recursiveArray));
        $this->assertFalse(Set::inArrayRecursive('plane', $this->recursiveArray));
    }

    public function testInArrayRecursiveEmpty()
    {
        $this->assertFalse(Set::inArrayRecursive('pizza'));
    }

    public function testExtractRoot()
    {
        $this->assertEqual($this->dataArray, Set::extract($this->dataArray, '/'));
    }

    public function testExtractItem()
    {
        $this->assertEqual(array(0, 3, 1, 2, 6), Set::extract($this->dataArray, '/id'));
    }

    public function testExtractSubItem()
    {
        $this->assertEqual(
            array('Apple', 'Orange', 'Banana', 'Strawberry', 'Lemon'), Set::extract($this->dataArray, '/item/name')
        );
    }

}
