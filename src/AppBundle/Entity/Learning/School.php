<?php

namespace AppBundle\Entity\Learning;

use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school",
 *     indexes={
 *         @ORM\Index(name="fk_schools_edition1", columns={"edition_id"}),
 *         @ORM\Index(name="busca", columns={"state_id", "city_id"}),
 *         @ORM\Index(name="busca_estado", columns={"state_id"}),
 *         @ORM\Index(name="edition_city", columns={"edition_id", "city_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Learning\SchoolRepository")
 */
class School
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="edition_id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $editionId;

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
     * @ORM\Column(name="localization_id", type="smallint", nullable=true)
     */
    private $localizationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="dependence_id", type="smallint", nullable=true)
     */
    private $dependenceId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEditionId(): int
    {
        return $this->editionId;
    }

    public function setEditionId(int $editionId)
    {
        $this->editionId = $editionId;
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

    public function getLocalizationId(): int
    {
        return $this->localizationId;
    }

    public function setLocalizationId(int $localizationId)
    {
        $this->localizationId = $localizationId;
    }

    public function getDependenceId(): int
    {
        return $this->dependenceId;
    }

    public function setDependenceId(int $dependenceId)
    {
        $this->dependenceId = $dependenceId;
    }
}
