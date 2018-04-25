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
        $proficiencyRepositoryMock = $this->getProficiencyRepositoryMockInBrazilCase();
        $learningFactoryMock = $this->getLearningFactoryMock();
        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();

        $learningService = new LearningService($proficiencyRepositoryMock, $learningFactoryMock);
        $brazilLearning = $learningService->getBrazilLearningByEdition($provaBrasilEdition);

        $brazilLearningExpected = LearningFixture::getLearningCollection();

        $this->assertEquals($brazilLearningExpected, $brazilLearning);
    }

    public function testGetSchoolLearningByEdition()
    {
        $proficiencyRepositoryMock = $this->getProficiencyRepositoryMockInSchoolCase();
        $learningFactoryMock = $this->getLearningFactoryMock();
        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();
        $schoolMock = $this->getSchoolEntityMock();

        $learningService = new LearningService($proficiencyRepositoryMock, $learningFactoryMock);
        $schoolLearning = $learningService->getSchoolLearningByEdition($schoolMock, $provaBrasilEdition);

        $schoolLearningExpected = LearningFixture::getLearningCollection();

        $this->assertEquals($schoolLearningExpected, $schoolLearning);
    }

    private function getProficiencyRepositoryMockInBrazilCase()
    {
        $proficiencyRepository = $this->getProficiencyRepositoryMock();

        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();
        $proficiencyEntity = ProficiencyEntityFixture::getProficiencyEntities();

        $proficiencyRepository->expects($this->once())
            ->method('findBrazilProficiencyByEdition')
            ->with($this->equalTo($provaBrasilEdition))
            ->willReturn($proficiencyEntity);

        return $proficiencyRepository;
    }

    private function getProficiencyRepositoryMockInSchoolCase()
    {
        $proficiencyRepository = $this->getProficiencyRepositoryMock();

        $schoolExpected = $this->getSchoolEntityMock();
        $provaBrasilEdition = ProvaBrasilEditionFixture::getProvaBrasilEdition();
        $proficiencyEntity = ProficiencyEntityFixture::getProficiencyEntities();

        $proficiencyRepository->expects($this->once())
            ->method('findSchoolProficiencyByEdition')
            ->with(
                $this->equalTo($schoolExpected),
                $this->equalTo($provaBrasilEdition)
            )
            ->willReturn($proficiencyEntity);

        return $proficiencyRepository;
    }

    private function getSchoolEntityMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(12392);

        return $schoolMock;
    }

    private function getProficiencyRepositoryMock()
    {
        $proficiencyRepository = $this->createMock('AppBundle\Repository\ProficiencyRepositoryInterface');

        return $proficiencyRepository;
    }

    private function getLearningFactoryMock()
    {
        $proficiencyEntity = ProficiencyEntityFixture::getProficiencyEntities();
        $brazilLearning = LearningFixture::getLearningCollection();

        $learningFactoryMock = $this->createMock('AppBundle\Learning\LearningFactoryInterface');

        $learningFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($proficiencyEntity))
            ->willReturn($brazilLearning);

        return $learningFactoryMock;
    }
}
