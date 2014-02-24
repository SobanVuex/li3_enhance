<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\util;

use li3_enhance\util\Util;

class UtilTest extends \lithium\test\Unit
{

    /**
     * @var array
     */
    protected $recursiveArray = array(
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

    /**
     * Test for inArrayRecursive()
     */
    public function testInArrayRecursive()
    {
        $this->assertTrue(Util::inArrayRecursive('pulp', $this->recursiveArray));
        $this->assertTrue(Util::inArrayRecursive('orange', $this->recursiveArray));

        $this->assertFalse(Util::inArrayRecursive('pizza', $this->recursiveArray));
    }

    /**
     * Test for fileInfo()
     */
    public function testFileInfo()
    {
        $this->assertTrue(Util::fileInfo(__FILE__));
        $this->assertTrue(Util::fileInfo(__DIR__, array('dir')));
        $this->assertTrue(Util::fileInfo(__FILE__, array('read')));
        $this->assertTrue(Util::fileInfo(__FILE__, array('write')));

        $this->assertFalse(Util::fileInfo(__FILE__, array('exec')));
        $this->assertFalse(Util::fileInfo(__FILE__, array('link')));
    }

    /**
     * Test for fileSum()
     */
    public function testFileSum()
    {
        $this->assertEqual(sha1_file(__FILE__), Util::fileSum(__FILE__));
        $this->assertEqual(sha1_file(__FILE__, true), Util::fileSum(__FILE__, Util::HASH_SHA1, true));

        $this->assertEqual(md5_file(__FILE__), Util::fileSum(__FILE__, Util::HASH_MD5));
        $this->assertEqual(md5_file(__FILE__, true), Util::fileSum(__FILE__, Util::HASH_MD5, true));

        $this->assertNotEqual(Util::fileSum(__FILE__), Util::fileSum(__FILE__, Util::HASH_MD5));
    }

}
