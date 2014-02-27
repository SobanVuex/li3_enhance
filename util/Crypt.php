<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for Li3 applications
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\util;

/**
 * @package li3_enhance
 */
class Crypt
{

    /**
     * Encryption options
     *
     * @var array
     */
    protected static $_defaults = array(
        'base64' => true,
        'serialize' => true,
        'data' => null,
        'ssl.method' => 'AES-128-CBC',
        'ssl.options' => 0,
        'iv.chiper' => MCRYPT_RIJNDAEL_128,
        'iv.mode' => MCRYPT_MODE_CBC,
        'iv.source' => MCRYPT_RAND,
        'iv.size' => null,
        'iv.vector' => null,
    );

    /**
     * List of variable types which can be encrypted
     *
     * @var array
     */
    protected static $_cryptable = array(
        'boolean',
        'integer',
        'double',
        'string',
        'array',
        'object',
        'NULL'
    );

    /**
     * Manage the initialization vector
     *
     * @param  array $options
     * @return array
     */
    protected static function vector(array $options = array())
    {
        $size = $options['iv.size'] ? : mcrypt_get_iv_size($options['iv.chiper'], $options['iv.mode']);
        if (!$options['iv.vector'] && $options['data']) {
            $vector = substr($options['data'], 0, $size);
        } else {
            $vector = $options['iv.vector'] ? : mcrypt_create_iv($size, $options['iv.source']);
        }

        return $options['data'] ? array($vector, $size) : array($vector);
    }

    /**
     * Securely encrypt the message
     *
     * @param  mixed  $data     Message. All non numeric/non string data will be serialized
     * @param  string $password Password
     * @param  string $method   [optional] Cipher
     * @param  array  $vector   [optional] Initialization Vector. Must contain both `size` and `iv` keys
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function encrypt($data, $password, array $options = array())
    {
        $options += self::$_defaults;
        $type = gettype($data);

        if (!in_array($type, self::$_cryptable)) {
            throw new \InvalidArgumentException("Type `{$type}` can not be encrypted.");
        }
        if ($options['serialize']) {
            $data = 'serialized.' . serialize($data);
        }

        list($vector) = self::vector($options);
        $encrypted = openssl_encrypt($data, $options['ssl.method'], $password, $options['ssl.options'], $vector);

        return $options['base64'] ? base64_encode($vector . $encrypted) : $vector . $encrypted;
    }

    /**
     * Decrypt the securely encrypted message
     *
     * @param  mixed   $data     Encrypted message.
     * @param  string  $password Password
     * @param  array   $options  [optional] Options
     * @return mixed
     */
    public static function decrypt($data, $password, array $options = array())
    {
        $options += self::$_defaults;

        if ($options['base64']) {
            $data = base64_decode($data);
        }

        list($vector, $size) = self::vector(compact('data') + $options);
        $decrypted = openssl_decrypt(substr($data, $size), $options['ssl.method'], $password, $options['ssl.options'], $vector);

        if (strpos($decrypted, 'serialized.') === 0) {
            $decrypted = substr($decrypted, 11);
            $options['serialize'] = true;
        }

        return $options['serialize'] ? unserialize($decrypted) : $decrypted;
    }

}
