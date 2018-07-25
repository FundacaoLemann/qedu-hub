<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="fact_proficiency",
 *     indexes={
 *         @ORM\Index(
 *             name="fk_fact_proficiency_2013_dim_politic_aggregation1_idx",
 *             columns={
 *                 "dim_politic_aggregation_id"
 *             }
 *         ),
 *         @ORM\Index(
 *             name="state_id",
 *             columns={
 *                 "partition_state_id"
 *             }
 *         )
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProficiencyRepository")
 */
class Proficiency
{
    /**
     * @ORM\Column(name="dim_politic_aggregation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $dimPoliticAggregationId;

    /**
     * @ORM\Column(name="dim_regional_aggregation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $dimRegionalAggregationId;

    /**
     * @ORM\Column(name="partition_state_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $partitionStateId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DimPoliticAggregation", fetch="EAGER")
     * @ORM\JoinColumn(name="dim_politic_aggregation_id", referencedColumnName="id")
     */
    public $dimPoliticAggregation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DimRegionalAggregation", fetch="EAGER")
     * @ORM\JoinColumn(name="dim_regional_aggregation_id", referencedColumnName="id")
     */
    public $dimRegionalAggregation;

    /**
     * @ORM\Column(name="with_proficiency_weight", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $withProficiencyWeight;

    /**
     * @ORM\Column(name="level_optimal", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $levelOptimal;

    /**
     * @ORM\Column(name="qualitative_0", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $qualitative0;

    /**
     * @ORM\Column(name="qualitative_1", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $qualitative1;

    /**
     * @ORM\Column(name="qualitative_2", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $qualitative2;

    /**
     * @ORM\Column(name="qualitative_3", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $qualitative3;

    public function getDimPoliticAggregationId(): int
    {
        return $this->dimPoliticAggregationId;
    }

    public function getDimRegionalAggregationId(): int
    {
        return $this->dimRegionalAggregationId;
    }

    public function getPartitionStateId(): int
    {
        return $this->partitionStateId;
    }

    public function getDimPoliticAggregation(): DimPoliticAggregation
    {
        return $this->dimPoliticAggregation;
    }

    public function setDimPoliticAggregation(DimPoliticAggregation $dimPoliticAggregation)
    {
        $this->dimPoliticAggregation = $dimPoliticAggregation;
    }

    public function getDimRegionalAggregation(): DimRegionalAggregation
    {
        return $this->dimRegionalAggregation;
    }

    public function setDimRegionalAggregation(DimRegionalAggregation $dimRegionalAggregation)
    {
        $this->dimRegionalAggregation = $dimRegionalAggregation;
    }

    public function getWithProficiencyWeight(): string
    {
        return $this->withProficiencyWeight;
    }

    public function setWithProficiencyWeight(string $withProficiencyWeight)
    {
        $this->withProficiencyWeight = $withProficiencyWeight;
    }

    public function getLevelOptimal(): string
    {
        return $this->levelOptimal;
    }

    public function setLevelOptimal(string $levelOptimal)
    {
        $this->levelOptimal = $levelOptimal;
    }

    public function getQualitative0(): string
    {
        return $this->qualitative0;
    }

    public function setQualitative0(string $qualitative0)
    {
        $this->qualitative0 = $qualitative0;
    }

    public function getQualitative1(): string
    {
        return $this->qualitative1;
    }

    public function setQualitative1(string $qualitative1)
    {
        $this->qualitative1 = $qualitative1;
    }

    public function getQualitative2(): string
    {
        return $this->qualitative2;
    }

    public function setQualitative2(string $qualitative2)
    {
        $this->qualitative2 = $qualitative2;
    }

    public function getQualitative3(): string
    {
        return $this->qualitative3;
    }

    public function setQualitative3(string $qualitative3)
    {
        $this->qualitative3 = $qualitative3;
    }
}
