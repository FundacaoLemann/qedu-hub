<?php

namespace AppBundle\Entity\Census;

use AppBundle\Entity\Census\Group\{
    Accessibility,
    BuildingCharacteristic,
    EnrollmentsAggregation,
    EnrollmentsGrade,
    Equipments,
    Food,
    OthersInformation,
    Services,
    Technologies
};
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school_educacenso",
 *     indexes={
 *         @ORM\Index(name="busca", columns={"educacenso", "state_id", "school_id", "city_id"}),
 *         @ORM\Index(name="escola", columns={"school_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Census\SchoolRepository")
 */
class School
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="state_id", type="smallint", nullable=false)
     */
    private $stateId;

    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="smallint", nullable=false)
     */
    private $cityId;

    /**
     * @var integer
     *
     * @ORM\Column(name="school_id", type="integer", nullable=false)
     */
    private $schoolId;

    /**
     * @var integer
     *
     * @ORM\Column(name="educacenso", type="smallint", nullable=false)
     */
    private $educacenso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prova_brasil", type="boolean", nullable=false)
     */
    private $hasProvaBrasil = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="cadastro_fax", type="integer", nullable=true)
     */
    private $faxNumber;

    /**
     * @var Accessibility
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\Accessibility", columnPrefix="acessibilidade_")
     */
    private $accessibility;

    /**
     * @var Food
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\Food", columnPrefix="alimentacao_")
     */
    private $food;

    /**
     * @var BuildingCharacteristic
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\BuildingCharacteristic", columnPrefix="dependencias_")
     */
    private $buildingCharacteristic;

    /**
     * @var Services
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\Services", columnPrefix="servicos_")
     */
    private $services;

    /**
     * @var Technologies
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\Technologies", columnPrefix="tecnologia_")
     */
    private $technologies;

    /**
     * @var Equipments
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\Equipments", columnPrefix="equipamento_")
     */
    private $equipments;

    /**
     * @var OthersInformation
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\OthersInformation", columnPrefix="outros_")
     */
    private $othersInformation;

    /**
     * @var EnrollmentsAggregation
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\EnrollmentsAggregation", columnPrefix=false)
     */
    private $enrollmentsAggregation;

    /**
     * @var EnrollmentsGrade
     *
     * @ORM\Embedded(class="AppBundle\Entity\Census\Group\EnrollmentsGrade", columnPrefix=false)
     */
    private $enrollmentsGrade;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStateId(): int
    {
        return $this->stateId;
    }

    public function setStateId(int $stateId)
    {
        $this->stateId = $stateId;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $cityId)
    {
        $this->cityId = $cityId;
    }

    public function getSchoolId(): int
    {
        return $this->schoolId;
    }

    public function setSchoolId(int $schoolId)
    {
        $this->schoolId = $schoolId;
    }

    public function getEducacenso(): int
    {
        return $this->educacenso;
    }

    public function setEducacenso(int $educacenso)
    {
        $this->educacenso = $educacenso;
    }

    public function hasProvaBrasil(): bool
    {
        return $this->hasProvaBrasil;
    }

    public function getFaxNumber(): ?int
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(?int $faxNumber)
    {
        $this->faxNumber = $faxNumber;
    }

    public function getAccessibility(): Accessibility
    {
        return $this->accessibility;
    }

    public function getFood(): Food
    {
        return $this->food;
    }

    public function getBuildingCharacteristic(): BuildingCharacteristic
    {
        return $this->buildingCharacteristic;
    }

    public function getServices(): Services
    {
        return $this->services;
    }

    public function getTechnologies(): Technologies
    {
        return $this->technologies;
    }

    public function getEquipments(): Equipments
    {
        return $this->equipments;
    }

    public function getOthersInformation(): OthersInformation
    {
        return $this->othersInformation;
    }

    public function getEnrollmentsAggregation(): EnrollmentsAggregation
    {
        return $this->enrollmentsAggregation;
    }

    public function getEnrollmentsGrade(): EnrollmentsGrade
    {
        return $this->enrollmentsGrade;
    }
}
