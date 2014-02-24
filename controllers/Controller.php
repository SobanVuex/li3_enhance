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
     * @param  array|string $message
     * @param  integer      $flag http://php.net/manual/en/function.syslog.php
     * @return boolean
     */
    protected function log($message, $flag = LOG_NOTICE)
    {
        if (!is_array($message)) {
            $message = array(
                'message' => $message
            );
        }

        $message = json_encode($message + array(
            'remote_addr' => $this->request->env('REMOTE_ADDR')
        ));

        switch ($flag) {
            case LOG_EMERG:
                return (boolean) Logger::emergency($message);
            case LOG_ALERT:
                return (boolean) Logger::alert($message);
            case LOG_CRIT:
                return (boolean) Logger::critical($message);
            case LOG_ERR:
                return (boolean) Logger::error($message);
            case LOG_WARNING:
                return (boolean) Logger::warning($message);
            case LOG_NOTICE:
                return (boolean) Logger::notice($message);
            case LOG_DEBUG:
                return (boolean) Logger::debug($message);
            default:
                return (boolean) Logger::notice($message);
        }
    }

}