<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\SchoolProficiency;
use PHPUnit\Framework\TestCase;

class SchoolProficiencyTest extends TestCase
{
    /**
     * @dataProvider hasProficiencyInLastEditionDataProvider
     */
    public function testHasProficiencyInLastEdition($repositoryResult, $expectedResult)
    {
        $schoolLearningRepository = $this->getSchoolLearningRepositoryMock($repositoryResult);
        $provaBrasilService = $this->getProvaBrasilServiceMock();
        $school = $this->getSchoolMock();

        $schoolProficiency = new SchoolProficiency($schoolLearningRepository, $provaBrasilService);
        $hasProficiencyInLastEdition = $schoolProficiency->hasProficiencyInLastEdition($school);

        $this->assertEquals($expectedResult, $hasProficiencyInLastEdition);
    }

    public function hasProficiencyInLastEditionDataProvider()
    {
        return [
            'without_proficiency' => [null, false],
            'with_proficiency' => [$this->getSchoolMock(), true],
        ];
    }

    private function getSchoolLearningRepositoryMock($repositoryResult)
    {
        $schoolLearningRepositoryMock = $this->createMock('AppBundle\Repository\Learning\SchoolRepositoryInterface');
        $schoolLearningRepositoryMock->method('findSchoolProficiencyByEdition')
            ->with(
                $this->getSchoolMock(),
                $this->getProvaBrasilEditionMock()
            )
            ->willReturn($repositoryResult);

        return $schoolLearningRepositoryMock;
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        return $schoolMock;
    }

    private function getProvaBrasilServiceMock()
    {
        $provaBrasilServiceMock = $this->createMock('AppBundle\Learning\ProvaBrasilService');

        $provaBrasilServiceMock->method('getLastEdition')
            ->willReturn($this->getProvaBrasilEditionMock());

        return $provaBrasilServiceMock;
    }

    private function getProvaBrasilEditionMock()
    {
        $provaBrasilEditionMock = $this->createMock('AppBundle\Learning\ProvaBrasilEdition');

        $provaBrasilEditionMock->method('getCode')
            ->willReturn(6);

        return $provaBrasilEditionMock;
    }
}
