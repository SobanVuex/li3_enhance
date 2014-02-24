<?php

/**
 * Kodb.in - Simple code/text sharing service
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\controllers;

use lithium\analysis\Logger;

/**
 * Base application controller
 *
 * @package li3_enhance
 */
class Controller extends \lithium\action\Controller
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
    protected function log($message, $flag = LOG_NOTICE)
    {
        if (isset($this->loggerPriorities[$flag])) {
            $flag = LOG_NOTICE;
        }

        if (!is_array($message)) {
            $message = array('message' => $message);
        }

        $message += array('remote_addr' => $this->request->env('REMOTE_ADDR'));

        return (boolean) Logger::write($this->loggerPriorities[$flag], json_encode($message));
    }

}
