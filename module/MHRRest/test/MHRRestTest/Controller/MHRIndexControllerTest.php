<?php
namespace MHRRestTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 2/28/14
 * Time: 4:19 PM
 */

class MHRIndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include '/home/mhrilwan/Sites/zf2-practicals/zf2-practicals/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/album');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('MHRRest');
        $this->assertControllerName('MHRRest\Controller\MHRIndex');
        $this->assertControllerClass('MHRIndexController');
        $this->assertMatchedRouteName('MHRIndex');
    }
}
 