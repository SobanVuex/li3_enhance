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

    /**
     * Test for inArrayRecursive()
     */
    public function testInArrayRecursive()
    {
        $data = array(
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

        $this->assertTrue(Set::inArrayRecursive('pulp', $data));
        $this->assertTrue(Set::inArrayRecursive('orange', $data));

        $this->assertFalse(Set::inArrayRecursive('pizza', $data));
        $this->assertFalse(Set::inArrayRecursive('pizza'));
    }

    /**
     * Test for extract()
     */
    public function testExtract()
    {
        $data = array(
            array('id' => 0, 'item' => array('name' => 'Apple')),
            array('id' => 3, 'item' => array('name' => 'Orange')),
            array('id' => 1, 'item' => array('name' => 'Banana')),
            array('id' => 2, 'item' => array('name' => 'Strawberry')),
            array('id' => 6, 'item' => array('name' => 'Lemon'))
        );

        $this->assertEqual($data, Set::extract($data, '/'));
        $this->assertEqual(array(0, 3, 1, 2, 6), Set::extract($data, '/id'));
        $this->assertEqual(
            array('Apple', 'Orange', 'Banana', 'Strawberry', 'Lemon'), Set::extract($data, '/item/name')
        );
    }

}
