<?php

namespace Tests\Unit\QEdu\QEduHub\GimmeBundle\Controller;

use PHPUnit\Framework\TestCase;
use GimmeBundle\Controller\DefaultController;

class DefaultControllerTest extends TestCase
{
    /**
     * @expectedException        Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage File not found
     */
    public function testIndexActionShouldThrownNotFoundException()
    {
        $fileLocatorMock = $this->getFileLocatorMock();

        $fileLocatorMock->method('locate')
            ->will($this->throwException(new \InvalidArgumentException));

        $defaultController = new DefaultController($fileLocatorMock);
        $defaultController->indexAction('unknow_file.js');
    }

    private function getFileLocatorMock()
    {
        return $this->getMockBuilder('Symfony\Component\HttpKernel\Config\FileLocator')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
