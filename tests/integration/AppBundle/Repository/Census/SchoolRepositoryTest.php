<?php

namespace Tests\Integration\AppBundle\Repository\Census;

use AppBundle\Entity\Census\School;
use AppBundle\Census\CensusEdition;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Fixture\Database\SchoolCensusTableFixture;

class SchoolRepositoryTest extends KernelTestCase
{
    private $schoolCensusTableFixture;
    private $emSchool;

    /**
     * @dataProvider findSchoolCensusByEditionDataProvider
     */
    public function testFindSchoolCensusByEdition($school, $censusEdition, $resultExpected)
    {
        $result = $this->emSchool
            ->getRepository(School::class)
            ->findSchoolCensusByEdition($school, $censusEdition);

        $this->assertEquals($resultExpected, count($result));
    }

    public function findSchoolCensusByEditionDataProvider()
    {
        return [
            'with_school_census' => [
                $this->getSchoolMock(),
                new CensusEdition(2017),
                $schoolFound = 1,
            ],
            'without_school_census' => [
                $this->getSchoolMock(),
                new CensusEdition(2007),
                $schoolFound = 0,
            ],
        ];
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolMainAttributesExpected()
    {
        $school = $this->findSchoolCensusByEdition();

        $this->assertEquals(2190587, $school->getId());
        $this->assertEquals(113, $school->getStateId());
        $this->assertEquals(1597, $school->getCityId());
        $this->assertEquals(142950, $school->getSchoolId());
        $this->assertEquals(2017, $school->getEducacenso());
        $this->assertFalse($school->hasProvaBrasil());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolAccessibilityAndFoodExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $accessibility = $school->getAccessibility();
        $food = $school->getFood();

        $this->assertNull($school->getFaxNumber());
        $this->assertFalse($accessibility->hasAccessibilityInDependencies());
        $this->assertFalse($accessibility->hasAccessibilityInToilets());
        $this->assertTrue($food->hasFoodProvided());
        $this->assertTrue($food->hasFilteredWater());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolBuildingCharacteristicExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $buildingCharacteristic = $school->getBuildingCharacteristic();

        $this->assertTrue($buildingCharacteristic->hasToiletInside());
        $this->assertFalse($buildingCharacteristic->hasToiletOutside());
        $this->assertTrue($buildingCharacteristic->hasLibrary());
        $this->assertTrue($buildingCharacteristic->hasKitchen());
        $this->assertTrue($buildingCharacteristic->hasComputerLab());
        $this->assertFalse($buildingCharacteristic->hasScienceLab());
        $this->assertFalse($buildingCharacteristic->hasReadingRoom());
        $this->assertTrue($buildingCharacteristic->hasSportsCourt());
        $this->assertTrue($buildingCharacteristic->hasBoardRoom());
        $this->assertTrue($buildingCharacteristic->hasTeachersRoom());
        $this->assertFalse($buildingCharacteristic->hasRoomServiceSpecial());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolBasicSanitationAndSupplyExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $services = $school->getServices();

        $this->assertFalse($services->hasWaterPublicNetwork());
        $this->assertTrue($services->hasArtesianWellWater());
        $this->assertFalse($services->hasWaterReservoir());
        $this->assertFalse($services->hasWaterRiver());
        $this->assertFalse($services->hasNotWater());
        $this->assertTrue($services->hasPublicNetworkPower());
        $this->assertFalse($services->hasGeneratorPower());
        $this->assertFalse($services->hasPowerFromOthersSources());
        $this->assertFalse($services->hasNotEnergy());
        $this->assertFalse($services->hasPublicSewerSystem());
        $this->assertTrue($services->hasSepticTank());
        $this->assertFalse($services->hasNotSewerSystem());
        $this->assertTrue($services->hasPeriodicGarbageCollection());
        $this->assertFalse($services->hasBurnGarbage());
        $this->assertFalse($services->hasTransferGarbageToOtherArea());
        $this->assertFalse($services->hasWasteRecycling());
        $this->assertFalse($services->hasGarbageBuried());
        $this->assertFalse($services->hasOtherGarbageDestination());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolTechnologiesAndEquipmentsExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $technologies = $school->getTechnologies();
        $equipments = $school->getEquipments();

        $this->assertTrue($technologies->hasInternet());
        $this->assertFalse($technologies->hasBroadband());
        $this->assertEquals(10, $technologies->getStudentComputersUnits());
        $this->assertEquals(1, $technologies->getAdministrativeComputersUnits());
        $this->assertTrue($equipments->hasDvd());
        $this->assertTrue($equipments->hasPrinter());
        $this->assertTrue($equipments->hasCopyMachine());
        $this->assertTrue($equipments->hasOverheadProjector());
        $this->assertTrue($equipments->hasTv());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolOthersInformationExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $othersInformation = $school->getOthersInformation();

        $this->assertEquals(30, $othersInformation ->getEmployeesNumber());
        $this->assertTrue($othersInformation ->hasOrganizationByCycles());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolEnrollmentAggregationsExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $enrollmentsAggregation = $school->getEnrollmentsAggregation();

        $this->assertEquals(0, $enrollmentsAggregation->getNurseryEnrollments());
        $this->assertEquals(28, $enrollmentsAggregation->getPreSchoolEnrollments());
        $this->assertEquals(103, $enrollmentsAggregation->getElementaryEnrollments());
        $this->assertEquals(100, $enrollmentsAggregation->getMiddleEnrollments());
        $this->assertEquals(0, $enrollmentsAggregation->getHighSchoolEnrollments());
        $this->assertEquals(0, $enrollmentsAggregation->getEjaEnrollments());
        $this->assertEquals(7, $enrollmentsAggregation->getSpecialEducationEnrollments());
    }

    public function testFindSchoolCensusByEditionShouldReturnSchoolEnrollmentByGradeExpected()
    {
        $school = $this->findSchoolCensusByEdition();
        $enrollmentsGrade = $school->getEnrollmentsGrade();

        $this->assertEquals(15, $enrollmentsGrade->getGrade1());
        $this->assertEquals(24, $enrollmentsGrade->getGrade2());
        $this->assertEquals(24, $enrollmentsGrade->getGrade3());
        $this->assertEquals(24, $enrollmentsGrade->getGrade4());
        $this->assertEquals(16, $enrollmentsGrade->getGrade5());
        $this->assertEquals(18, $enrollmentsGrade->getGrade6());
        $this->assertEquals(22, $enrollmentsGrade->getGrade7());
        $this->assertEquals(26, $enrollmentsGrade->getGrade8());
        $this->assertEquals(34, $enrollmentsGrade->getGrade9());
        $this->assertEquals(0, $enrollmentsGrade->getGrade10());
        $this->assertEquals(0, $enrollmentsGrade->getGrade11());
        $this->assertEquals(0, $enrollmentsGrade->getGrade12());
    }

    private function findSchoolCensusByEdition()
    {
        $result = $this->emSchool
            ->getRepository(School::class)
            ->findSchoolCensusByEdition($this->getSchoolMock(), new CensusEdition(2017));

        return $result;
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(142950);

        return $schoolMock;
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->schoolCensusTableFixture = new SchoolCensusTableFixture();
        $this->schoolCensusTableFixture->createTable($kernel);
        $this->schoolCensusTableFixture->populateWithSchoolRegister();

        $this->emSchool = $this->schoolCensusTableFixture->getEntityManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->schoolCensusTableFixture->dropTable();
    }
}
