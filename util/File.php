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
 * @package li3_enhance
 */
class File
{

    /**
     * @var integer
     */
    const SUM_SHA1 = 1;

    /**
     * @var integer
     */
    const SUM_MD5 = 2;


    /**
     * Check if a `$path` has one or more properties
     *
     * @param  string  $file
     * @param  array   $options
     * @return boolean
     */
    public static function info($file, array $options = array())
    {
        $defaults = array(
            'dir' => 'isDir',
            'exec' => 'isExecutable',
            'link' => 'isLink',
            'read' => 'isReadable',
            'write' => 'isWritable'
        );

        $info = true;
        $file = new \SplFileInfo($file);
        $options = array_intersect_key($defaults, array_flip($options));

        if (!isset($options['dir'])) {
            $options = array('file' => 'isFile') + $options;
        }

        foreach ($options as $check) {
            $info = $info && $file->{$check}();
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
    public static function sum($file, $method = self::SUM_SHA1, $raw = false)
    {
        if (!self::info($file, array('read'))) {
            return false;
        }

        if ($method === self::SUM_SHA1) {
            return sha1_file($file, $raw);
        } elseif ($method === self::SUM_MD5) {
            return md5_file($file, $raw);
        } else {
            $message = 'The `method` argument does not reference a correct hasing algorithm.';
            throw new \UnexpectedValueException($message);
        }
    }

}
