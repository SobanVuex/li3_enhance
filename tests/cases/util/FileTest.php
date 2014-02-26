<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\util;

use li3_enhance\util\File;

/**
 * @package li3_enhance
 */
class FileTest extends \lithium\test\Unit
{

    /**
     * Test for info()
     */
    public function testInfo()
    {
        $this->assertTrue(File::info(__FILE__));
        $this->assertTrue(File::info(__FILE__, array('read')));
        $this->assertTrue(File::info(__FILE__, array('write')));
        $this->assertTrue(File::info(__FILE__, array('read', 'write')));
        $this->assertFalse(File::info(__FILE__, array('exec')));
        $this->assertFalse(File::info(__FILE__, array('link')));
        $this->assertFalse(File::info(__FILE__, array('exec', 'link')));

        $this->assertTrue(File::info(__DIR__, array('dir')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'read')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'write')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'exec')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'read', 'write', 'exec')));
        $this->assertFalse(File::info(__DIR__, array('dir', 'link')));
    }

    /**
     * Test for sum()
     */
    public function testSum()
    {
        $this->assertEqual(sha1_file(__FILE__), File::sum(__FILE__));
        $this->assertEqual(sha1_file(__FILE__, true), File::sum(__FILE__, File::SUM_SHA1, true));

        $this->assertEqual(md5_file(__FILE__), File::sum(__FILE__, File::SUM_MD5));
        $this->assertEqual(md5_file(__FILE__, true), File::sum(__FILE__, File::SUM_MD5, true));

        $this->assertNotEqual(File::sum(__FILE__, File::SUM_SHA1), File::sum(__FILE__, File::SUM_MD5));
    }

}
