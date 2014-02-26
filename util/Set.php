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
class Set
{

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
     * Light implementation of XPath2
     *
     * @param  array  $data
     * @param  string $path
     * @return array
     */
    public static function extract(array $data = array(), $path = null)
    {
        if (!$data) {
            return array();
        }

        if ($path !== '/') {
            $paths = explode('/', $path);
            $data = array_map(function($item) use ($paths) {
                while ($key = next($paths)) {
                    $item = isset($item[$key]) ? $item[$key] : array();
                }

                return $item;
            }, $data);
        }

        return array_filter($data, function($item) {
            return ($item === 0 || $item === '0' || !empty($item));
        });
    }

}
