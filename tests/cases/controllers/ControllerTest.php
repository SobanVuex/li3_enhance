<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\controllers;

use lithium\analysis\Logger;
use lithium\tests\mocks\analysis\MockLoggerAdapter;
use lithium\tests\mocks\action\MockControllerRequest;
use li3_enhance\controllers\Controller;

class ControllerTest extends \lithium\test\Unit
{

    /**
     * Setup Logger configuration
     */
    public function setUp()
    {
        Logger::config(array(
            'default' => array(
                'adapter' => new MockLoggerAdapter()
            )
        ));
    }

    /**
     * Test for log()
     */
    public function testControllerLog()
    {
        $request = new MockControllerRequest();
        $controller = new Controller(compact('request'));

        $this->assertTrue($controller->invokeMethod('log', 'Controller::log test successsful'));
    }

}
