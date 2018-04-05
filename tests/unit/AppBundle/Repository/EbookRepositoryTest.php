<?php

namespace Tests\Unit\AppBundle\Repository;

use AppBundle\Repository\EbookRepository;
use PHPUnit\Framework\TestCase;

class EbookRepositoryTest extends TestCase
{
    private $ebookRepository;

    protected function setUp()
    {
        $this->ebookRepository = new EbookRepository();
    }

    protected function tearDown()
    {
        $this->ebookRepository = null;
    }

    public function testFindBySlugShouldReturnEbook()
    {
        $validEbookSlug = 'o-papel-do-coordenador-pedagogico';

        $ebook = $this->ebookRepository->findBySlug($validEbookSlug);

        $ebookExpected = $this->getExpectedEbook();

        $this->assertEquals($ebookExpected, $ebook);
    }

    private function getExpectedEbook()
    {
        return [
            'name' => 'O papel do coordenador pedagógico',
            'title' => 'Qual o verdadeiro papel do coordenador pedagógico na escola?',
            'description' => 'O livro digital “O papel do coordenador pedagógico” é uma publicação 
                                  digital gratuita feita com todo carinho pelo pessoal do QEdu que ensina tudo que você 
                                  precisa saber sobre as principais funções e atribuições desse profissional tão 
                                  importante para o pleno funcionamento da escola.',
            'content_list' => [
                'O que é o coordenador pedagógico e sua função na escola',
                'Como o coordenador pedagógico pode observar a sala de aula',
                '7 passos para o coordenador pedagógico planejar reuniões com professores',
                'O papel do coordenador pedagógico nas avaliações do aprendizado',
            ],
            'download_url' => '//s3-sa-east-1.amazonaws.com/cb-qedu-assets/img/qedu/ebook/'.
                              'QEdu+-+O+papel+do+coordenador+pedago%CC%81gico.pdf',
            'image_url' => '//s3-sa-east-1.amazonaws.com/cb-qedu-assets/img/qedu/ebook/'.
                           'ebook-coordenador-pedagogico.png',
        ];
    }

    public function testFindBySlugShouldReturnNull()
    {
        $invalidEbookSlug = 'invalid-slug';

        $ebook = $this->ebookRepository->findBySlug($invalidEbookSlug);

        $this->assertNull($ebook);
    }
}
