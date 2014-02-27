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

    public function testInfoFile()
    {
        $this->assertTrue(File::info(__FILE__));
    }

    public function testInfoFileParam()
    {
        $this->assertTrue(File::info(__FILE__, array('read')));
        $this->assertTrue(File::info(__FILE__, array('write')));
        $this->assertFalse(File::info(__FILE__, array('exec')));
        $this->assertFalse(File::info(__FILE__, array('link')));
    }

    public function testInfoFileParams()
    {
        $this->assertTrue(File::info(__FILE__, array('read', 'write')));
        $this->assertFalse(File::info(__FILE__, array('exec', 'link')));
    }

    public function testInfoDir()
    {
        $this->assertTrue(File::info(__DIR__, array('dir')));
    }

    public function testInfoDirParam()
    {
        $this->assertTrue(File::info(__DIR__, array('dir', 'read')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'write')));
        $this->assertTrue(File::info(__DIR__, array('dir', 'exec')));
        $this->assertFalse(File::info(__DIR__, array('dir', 'link')));
    }

    public function testInfoDirParams()
    {
        $this->assertTrue(File::info(__DIR__, array('dir', 'read', 'write', 'exec')));
    }

    public function testSumSha1()
    {
        $this->assertEqual(sha1_file(__FILE__), File::sum(__FILE__));
    }

    public function testSumSha1Raw()
    {
        $this->assertEqual(sha1_file(__FILE__, true), File::sum(__FILE__, File::SUM_SHA1, true));
    }

    public function testSumMd5()
    {

        $this->assertEqual(md5_file(__FILE__), File::sum(__FILE__, File::SUM_MD5));
    }

    public function testSumMd5Raw()
    {

        $this->assertEqual(md5_file(__FILE__, true), File::sum(__FILE__, File::SUM_MD5, true));
    }

    public function testSumSha1Md5()
    {
        $this->assertNotEqual(File::sum(__FILE__, File::SUM_SHA1), File::sum(__FILE__, File::SUM_MD5));
    }

}
