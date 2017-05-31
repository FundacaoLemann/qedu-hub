<?php

namespace Tests\Functional\QEdu\QEduHub\GimmeBundle\Service;

use QEdu\QEduHub\GimmeBundle\Util\FileLocator;

class AssetLocatorTest
{
    public function testGetContentShouldReturnFileContent()
    {
        $this->markTestIncomplete();

        $this->getMock('AppKernel');

        $assetLocator = new FileLocator($kernel);
        $content = $assetLocator->getContent($file);
    }
}
