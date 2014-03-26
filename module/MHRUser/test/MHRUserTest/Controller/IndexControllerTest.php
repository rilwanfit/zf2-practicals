<?php
/**
 * Created by PhpStorm.
 * User: mhrilwan
 * Date: 3/21/14
 * Time: 10:22 PM
 */

namespace MHRUserTest\Controller;

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */



use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MHRIndexControllerTest extends AbstractHttpControllerTestCase
{

    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
           // include '/home/mhrilwan/Sites/zf2-practicals/zf2-practicals/config/application.config.php',
            include '/Applications/MAMP/htdocs/zf2-practicals/config/application.config.php'

        );
        parent::setUp();
    }

    protected function getEmMock()
    {
        $emMock = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
        $emMock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue(new FakeRepository()));
        $emMock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue((object)array('name' => 'aClass')));
        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));
        return $emMock; // it tooks 13 lines to achieve mock!
    }

    public function testIndexActionCanBeAccessed()
    {

        $entityUserMock = $this->getEmMock();

        $entityUserMock->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('MHRUser\Entity\User', $entityUserMock);


        $this->dispatch('/mhr-user');
        $this->assertResponseStatusCode(200, 'The response code is ' . $this->getResponse());
        $this->assertModuleName('MHRUser');
        $this->assertControllerName('MHRUser\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('mhr-user');
    }
}