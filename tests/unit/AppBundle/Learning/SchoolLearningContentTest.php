<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\SchoolLearningContent;
use PHPUnit\Framework\TestCase;

class SchoolLearningContentTest extends TestCase
{
    public function testBuildShouldSchoolAndLearning()
    {
        $schoolId = 142950;
        $provaBrasilEdition = $this->createMock('AppBundle\Learning\ProvaBrasilEdition');

        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->method('findSchoolById')
            ->with($schoolId)
            ->willReturn($school);

        $schoolProficiency = $this->createMock('AppBundle\Entity\Learning\School');

        $schoolLearningRepository = $this->createMock('AppBundle\Repository\Learning\SchoolRepositoryInterface');
        $schoolLearningRepository->method('findSchoolProficiencyByEdition')
            ->with(
                $school,
                $provaBrasilEdition
            )
            ->willReturn($schoolProficiency);

        $schoolLearning = [
            $this->createMock('AppBundle\Learning\Learning'),
        ];

        $learningService = $this->createMock('AppBundle\Learning\learningService');
        $learningService->method('getSchoolLearningByEdition')
            ->with(
                $schoolProficiency,
                $provaBrasilEdition
            )
            ->willReturn($schoolLearning);

        $schoolLearningContent = new SchoolLearningContent(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningContent->build($schoolId, $provaBrasilEdition);

        $this->assertInstanceOf('AppBundle\Entity\School', $schoolLearningContent->getSchool());
        $this->assertEquals($schoolLearning, $schoolLearningContent->getSchoolLearning());
    }

    /**
     * @expectedException     \AppBundle\Exception\SchoolNotFoundException
     */
    public function testBuildShouldThrowSchoolNotFoundException()
    {
        $schoolId = 142950;
        $provaBrasilEdition = $this->createMock('AppBundle\Learning\ProvaBrasilEdition');

        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->method('findSchoolById')
            ->with($schoolId)
            ->willReturn(null);

        $schoolLearningRepository = $this->createMock('AppBundle\Repository\Learning\SchoolRepositoryInterface');

        $learningService = $this->createMock('AppBundle\Learning\learningService');

        $schoolLearningContent = new SchoolLearningContent(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningContent->build($schoolId, $provaBrasilEdition);
    }

    /**
     * @expectedException     \AppBundle\Exception\SchoolLearningNotFoundException
     */
    public function testBuildShouldThrowSchoolLearningNotFoundException()
    {
        $schoolId = 142950;
        $provaBrasilEdition = $this->createMock('AppBundle\Learning\ProvaBrasilEdition');

        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->method('findSchoolById')
            ->with($schoolId)
            ->willReturn($school);

        $schoolLearningRepository = $this->createMock('AppBundle\Repository\Learning\SchoolRepositoryInterface');
        $schoolLearningRepository->method('findSchoolProficiencyByEdition')
            ->with(
                $school,
                $provaBrasilEdition
            )
            ->willReturn(null);

        $learningService = $this->createMock('AppBundle\Learning\learningService');

        $schoolLearningContent = new SchoolLearningContent(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningContent->build($schoolId, $provaBrasilEdition);
    }
}
