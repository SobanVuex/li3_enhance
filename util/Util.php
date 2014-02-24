<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\util;

/**
 * Utility providing additional methods
 *
 * @package li3_enhance
 */
class Util
{

    /**
     * @var integer
     */
    const HASH_SHA1 = 1;

    /**
     * @var integer
     */
    const HASH_MD5 = 2;

    /**
     * Check for `$needle` in array recursively
     *
     * @param  mixed   $needle
     * @param  array   $haystack
     * @return boolean
     */
    public static function inArrayRecursive($needle, array $haystack = array())
    {
        if (!$haystack) {
            return false;
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($haystack));
        foreach ($iterator as $element) {
            if ($element === $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a `$path` has one or more properties
     *
     * @param  string  $file
     * @param  array   $options
     * @return boolean
     */
    public static function fileInfo($file, array $options = array())
    {
        $defaults = array(
            'dir' => 'isDir',
            'exec' => 'isExecutable',
            'link' => 'isLink',
            'read' => 'isReadable',
            'write' => 'isWritable'
        );

        $file = new \SplFileInfo($file);
        $options = array_intersect_key($defaults, array_flip($options));

        if (isset($options['dir'])) {
            return $file->isDir();
        }

        $info = $file->isFile();
        foreach ($options as $check) {
            if ($info) {
                $info = $info && $file->{$check}();
            }
        }

        return $info;
    }

    /**
     * Get the hash sum for a file using sha1 (default) or md5
     *
     * @param  string       $file
     * @param  integer      $method
     * @param  boolean      $raw
     * @return string|false
     * @throws \UnexpectedValueException
     */
    public static function fileSum($file, $method = self::HASH_SHA1, $raw = false)
    {
        if (!self::fileInfo($file, array('read'))) {
            return false;
        }

        if ($method === self::HASH_SHA1) {
            return sha1_file($file, $raw);
        } elseif ($method === self::HASH_MD5) {
            return md5_file($file, $raw);
        } else {
            $message = 'The `method` argument does not reference a correct hasing algorithm.';
            throw new \UnexpectedValueException($message);
        }
    }

}
