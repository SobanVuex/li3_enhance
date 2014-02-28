<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\util;

use li3_enhance\util\Crypt;

/**
 * @package li3_enhance
 */
class CryptTest extends \lithium\test\Unit
{

    public function setUp()
    {
        $this->password = 'ps010ITXWGRfA';
    }

    public function testCryptableBoolean()
    {
        $this->assertTrue(Crypt::cryptable(true));
        $this->assertTrue(Crypt::cryptable(false));
    }

    public function testCryptableNumeric()
    {
        $this->assertTrue(Crypt::cryptable(123));
        $this->assertTrue(Crypt::cryptable(123.4));
    }

    public function testCryptableString()
    {
        $this->assertTrue(Crypt::cryptable('abc'));
    }

    public function testCryptableArray()
    {
        $this->assertTrue(Crypt::cryptable(array(1, 2, 3)));
        $this->assertTrue(Crypt::cryptable(array()));
    }

    public function testCryptableObject()
    {
        $this->assertTrue(Crypt::cryptable(new \stdClass()));
    }

    public function testNotCryptableResource()
    {
        $handle = fopen(__FILE__, 'r');
        $this->assertFalse(Crypt::cryptable($handle));
    }

    public function testNotCryptableUnknown()
    {
        $handle = fopen(__FILE__, 'r');
        fclose($handle);
        $this->assertFalse(Crypt::cryptable($handle));
    }

    public function testEncryptBoolean()
    {
        $this->assertNotEmpty(Crypt::encrypt(true, $this->password));
        $this->assertNotEmpty(Crypt::encrypt(false, $this->password));
    }

    public function testEncryptNumeric()
    {
        $this->assertNotEmpty(Crypt::encrypt(123, $this->password));
        $this->assertNotEmpty(Crypt::encrypt(123.4, $this->password));
    }

    public function testEncryptString()
    {
        $this->assertNotEmpty(Crypt::encrypt('abc', $this->password));
    }

    public function testEncryptArray()
    {
        $this->assertNotEmpty(Crypt::encrypt(array(1, 2, 3), $this->password));
        $this->assertNotEmpty(Crypt::encrypt(array(), $this->password));
    }

    public function testEncryptObject()
    {
        $this->assertNotEmpty(Crypt::encrypt(new \stdClass(), $this->password));
    }

    public function testEncryptResource()
    {
        $handle = fopen(__FILE__, 'r');
        $this->expectException('Type `resource` can not be encrypted.');
        Crypt::encrypt($handle, $this->password);
    }

    public function testEncryptUnknown()
    {
        $handle = fopen(__FILE__, 'r');
        fclose($handle);
        $this->expectException('Type `unknown type` can not be encrypted.');
        Crypt::encrypt($handle, $this->password);
    }

    public function testDecryptBoolean()
    {
        $encrypted = Crypt::encrypt(true, $this->password);
        $this->assertIdentical(true, Crypt::decrypt($encrypted, $this->password));

        $encrypted = Crypt::encrypt(false, $this->password);
        $this->assertIdentical(false, Crypt::decrypt($encrypted, $this->password));
    }

    public function testDecryptNumeric()
    {
        $encrypted = Crypt::encrypt(123, $this->password);
        $this->assertIdentical(123, Crypt::decrypt($encrypted, $this->password));
//
        $encrypted = Crypt::encrypt(123.4, $this->password);
        $this->assertIdentical(123.4, Crypt::decrypt($encrypted, $this->password));
    }

    public function testDecryptString()
    {
        $encrypted = Crypt::encrypt('abc', $this->password);
        $this->assertIdentical('abc', Crypt::decrypt($encrypted, $this->password));
    }

    public function testDecryptArray()
    {

        $value = array(1, 2, 3);
        $encrypted = Crypt::encrypt($value, $this->password);
        $this->assertIdentical($value, Crypt::decrypt($encrypted, $this->password));

        $value = array();
        $encrypted = Crypt::encrypt($value, $this->password);
        $this->assertIdentical($value, Crypt::decrypt($encrypted, $this->password));
    }

    public function testDecryptObject()
    {
        $encrypted = Crypt::encrypt(new \stdClass(), $this->password);
        $this->assertInstanceOf('stdClass', Crypt::decrypt($encrypted, $this->password));
    }

}
