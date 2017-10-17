<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\LearningService;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\BrazilLearningFixture;
use Tests\Fixture\LearningFixture;
use Tests\Fixture\ProficiencyEntityFixture;
use Tests\Fixture\ProvaBrasilEditionFixture;

class LearningServiceTest extends TestCase
{
    public function testGetBrazilLearningByEdition()
    {
        $proficiencyRepositoryMock = $this->getProficiencyRepositoryMock();
        $learningFactoryMock = $this->getLearningFactoryMock();
        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();

        $learningService = new LearningService($proficiencyRepositoryMock, $learningFactoryMock);
        $brazilLearning = $learningService->getBrazilLearningByEdition($provaBrasilEdition);

        $this->assertEquals($this->getLearnings(), $brazilLearning);
    }

    private function getProficiencyRepositoryMock()
    {
        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();
        $proficiencyEntity = ProficiencyEntityFixture::getProficiencyEntities();

        $proficiencyRepository = $this->createMock('AppBundle\Repository\ProficiencyRepositoryInterface');

        $proficiencyRepository->expects($this->once())
            ->method('findBrazilProficiencyByEdition')
            ->with($this->equalTo($provaBrasilEdition))
            ->willReturn($proficiencyEntity);

        return $proficiencyRepository;
    }

    private function getLearningFactoryMock()
    {
        $proficiencyEntity = ProficiencyEntityFixture::getProficiencyEntities();
        $brazilLearning = $this->getLearnings();

        $learningFactoryMock = $this->createMock('AppBundle\Learning\LearningFactoryInterface');

        $learningFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($proficiencyEntity))
            ->willReturn($brazilLearning);

        return $learningFactoryMock;
    }

    private function getLearnings(): array
    {
        $learnings[] = LearningFixture::getLearning();

        return $learnings;
    }
}
