<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemContent;
use PHPUnit\Framework\TestCase;

class EnemContentTest extends TestCase
{
    public function testBuildShouldConstructFilter()
    {
        $filter = $this->createMock('AppBundle\Enem\EnemFilter');

        $content = new EnemContent($filter);

        $this->assertInstanceOf('AppBundle\Enem\EnemFilter', $content->getFilter());
    }
}
