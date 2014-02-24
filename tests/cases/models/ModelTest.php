<?php

/**
 * Li3 Enhance - Collection of extensions and utilities for li3
 * 
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_enhance\tests\cases\models;

use lithium\analysis\Logger;
use lithium\tests\mocks\analysis\MockLoggerAdapter;
use li3_enhance\models\Model;

/**
 * Tests for \li3_enhance\models\Model
 *
 * @package li3_enhance
 */
class ModelTest extends \lithium\test\Unit
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
    public function testModelLog()
    {
        $model = new Model;

        $this->assertTrue($model->log('Model::log test successsful'));
    }

}
