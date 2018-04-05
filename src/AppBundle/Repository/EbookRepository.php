<?php

namespace AppBundle\Repository;

class EbookRepository
{
    public function findBySlug($slug)
    {
        $ebook = [
            'o-papel-do-coordenador-pedagogico' => [
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
            ],
            'guia-pratico-elaboracao-itens' => [
                'name' => 'Guia Prático de Elaboração de Itens',
                'title' => 'Quer aprender a elaborar itens de prova melhores?',
                'description' => 'O livro digital “Guia Prático de Elaboração de Itens” é uma publicação digital 
                                  gratuita feita com todo carinho pelo pessoal do QEdu que ensina tudo que você precisa 
                                  saber sobre como elaborar bons itens.',
                'content_list' => [
                    'O que é um item?',
                    'Como saber se um item é bom?',
                    'Estrutura do item de múltipla escolha',
                    'Matriz de Referência',
                    'Competências e Habilidades',
                    'Tópicos, Temas e Descritores',
                ],
                'download_url' => '//s3-sa-east-1.amazonaws.com/cb-qedu-assets/img/qedu/ebook/'.
                                  'QEdu+-+Guia+Pra%CC%81tico+de+Elaborac%CC%A7a%CC%83o+de+Itens.pdf',
                'image_url' => '//s3-sa-east-1.amazonaws.com/cb-qedu-assets/img/qedu/ebook/'.
                               'ebook-guia-pratico-itens.png',
            ],
        ];

        $ebookKey = $slug;

        if (array_key_exists($ebookKey, $ebook)) {
            return $ebook[$ebookKey];
        }

        return null;
    }
}
