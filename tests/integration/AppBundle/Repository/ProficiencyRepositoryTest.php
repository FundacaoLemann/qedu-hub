<?php

namespace Tests\Integration\AppBundle\Repository;

use AppBundle\Entity\Proficiency;
use AppBundle\Learning\ProvaBrasilEdition;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Fixture\Database\ProficiencyTableFixture;
use Tests\Fixture\ProficiencyEntityFixture;

class ProficiencyRepositoryTest extends KernelTestCase
{
    private $em;
    private $proficiencyTableFixture;

    public function testFindBrazilProficiencyByEdition()
    {
        $this->proficiencyTableFixture->populateWithBrazilRegister();

        $proficiencyExpected = ProficiencyEntityFixture::getProficiency();

        $proficiencies = $this->em
            ->getRepository(Proficiency::class)
            ->findBrazilProficiencyByEdition(new ProvaBrasilEdition(6, 2015));

        $this->assertCount(4, $proficiencies);
        $this->assertEquals(
            $proficiencyExpected->getWithProficiencyWeight(),
            $proficiencies[0]->getWithProficiencyWeight()
        );
        $this->assertEquals(
            $proficiencyExpected->getLevelOptimal(),
            $proficiencies[0]->getLevelOptimal()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative0(),
            $proficiencies[0]->getQualitative0()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative1(),
            $proficiencies[0]->getQualitative1()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative2(),
            $proficiencies[0]->getQualitative2()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative3(),
            $proficiencies[0]->getQualitative3()
        );
    }

    public function testFindSchoolProficiencyByEdition()
    {
        $this->proficiencyTableFixture->populateWithSchoolRegister();

        $proficiencyExpected = new Proficiency();
        $proficiencyExpected->setWithProficiencyWeight('25.02');
        $proficiencyExpected->setLevelOptimal('7.30');
        $proficiencyExpected->setQualitative0('5.21');
        $proficiencyExpected->setQualitative1('12.51');
        $proficiencyExpected->setQualitative2('4.17');
        $proficiencyExpected->setQualitative3('3.13');

        $schoolId = 142950;
        $proficiencies = $this->em
            ->getRepository(Proficiency::class)
            ->findSchoolProficiencyByEdition($schoolId, new ProvaBrasilEdition(6, 2015));

        $this->assertCount(4, $proficiencies);
        $this->assertEquals(
            $proficiencyExpected->getWithProficiencyWeight(),
            $proficiencies[0]->getWithProficiencyWeight()
        );
        $this->assertEquals(
            $proficiencyExpected->getLevelOptimal(),
            $proficiencies[0]->getLevelOptimal()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative0(),
            $proficiencies[0]->getQualitative0()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative1(),
            $proficiencies[0]->getQualitative1()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative2(),
            $proficiencies[0]->getQualitative2()
        );
        $this->assertEquals(
            $proficiencyExpected->getQualitative3(),
            $proficiencies[0]->getQualitative3()
        );
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->proficiencyTableFixture = new ProficiencyTableFixture();
        $this->proficiencyTableFixture->createTable($kernel);

        $this->em = $this->proficiencyTableFixture->getEntityManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->proficiencyTableFixture->dropTable();
    }
}
