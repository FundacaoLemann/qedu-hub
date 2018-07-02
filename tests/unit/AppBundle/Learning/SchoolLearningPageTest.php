<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\SchoolLearningPage;
use PHPUnit\Framework\TestCase;

class SchoolLearningPageTest extends TestCase
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

        $schoolLearningPage = new SchoolLearningPage(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningPage->build($schoolId, $provaBrasilEdition);

        $this->assertInstanceOf('AppBundle\Entity\School', $schoolLearningPage->getSchool());
        $this->assertEquals($schoolLearning, $schoolLearningPage->getSchoolLearning());
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

        $schoolLearningPage = new SchoolLearningPage(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningPage->build($schoolId, $provaBrasilEdition);
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

        $schoolLearningPage = new SchoolLearningPage(
            $schoolRepository,
            $schoolLearningRepository,
            $learningService
        );
        $schoolLearningPage->build($schoolId, $provaBrasilEdition);
    }
}
