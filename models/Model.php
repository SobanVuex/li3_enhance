<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\models;

use lithium\analysis\Logger;

/**
 * Base application model
 *
 * @package li3_enhance
 */
class Model extends \lithium\data\Model
{

    /**
     * @var array
     */
    protected $loggerPriorities = array(
        LOG_EMERG => 'emergency',
        LOG_ALERT => 'alert',
        LOG_CRIT => 'critical',
        LOG_ERR => 'error',
        LOG_WARNING => 'warning',
        LOG_NOTICE => 'notice',
        LOG_INFO => 'info',
        LOG_DEBUG => 'debug',
    );

    /**
     * @param  array|string $message
     * @param  integer      $flag http://php.net/manual/en/function.syslog.php
     * @return boolean
     */
    protected function log($message, $flag = LOG_WARNING)
    {
        if (isset($this->loggerPriorities[$flag])) {
            $flag = LOG_WARNING;
        }

        if (!is_array($message)) {
            $message = array('message' => $message);
        }

        $message += array('model' => get_called_class());

        var_dump($message);
        return (boolean) Logger::write($this->loggerPriorities[$flag], json_encode($message));
    }

}
