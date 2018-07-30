<?php

namespace Tests\Unit\AppBundle\Controller;

use AppBundle\Controller\EbookController;
use PHPUnit\Framework\TestCase;

class EbookControllerTest extends TestCase
{
    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testEbookControllerShouldThrowNotFoundHttpException()
    {
        $ebookRepository = $this->createMock('AppBundle\Repository\EbookRepository');
        $ebookRepository->method('findBySlug')
            ->willReturn(null);

        $ebookSlug = 'no-ebook';

        $ebookController = new EbookController($ebookRepository);
        $ebookController->ebookAction($ebookSlug);
    }
}
