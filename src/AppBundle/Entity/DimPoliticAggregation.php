<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DimPoliticAggregation
 *
 * @ORM\Table(name="dim_politic_aggregation", indexes={@ORM\Index(name="busca", columns={"dependence_id", "localization_id", "edition_id", "grade_id", "discipline_id"})})
 * @ORM\Entity
 */
class DimPoliticAggregation
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
     * @ORM\Column(name="dependence_id", type="integer", nullable=true)
     */
    private $dependenceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="localization_id", type="integer", nullable=true)
     */
    private $localizationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="edition_id", type="integer", nullable=true)
     */
    private $editionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="grade_id", type="integer", nullable=true)
     */
    private $gradeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="discipline_id", type="integer", nullable=true)
     */
    private $disciplineId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDependenceId(): int
    {
        return $this->dependenceId;
    }

    public function setDependenceId(int $dependenceId)
    {
        $this->dependenceId = $dependenceId;
    }

    public function getLocalizationId(): int
    {
        return $this->localizationId;
    }

    public function setLocalizationId(int $localizationId)
    {
        $this->localizationId = $localizationId;
    }

    public function getEditionId(): int
    {
        return $this->editionId;
    }

    public function setEditionId(int $editionId)
    {
        $this->editionId = $editionId;
    }

    public function getGradeId(): int
    {
        return $this->gradeId;
    }

    public function setGradeId(int $gradeId)
    {
        $this->gradeId = $gradeId;
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }

    public function setDisciplineId(int $disciplineId)
    {
        $this->disciplineId = $disciplineId;
    }
}
