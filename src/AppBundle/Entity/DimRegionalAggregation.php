<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="dim_regional_aggregation",
 *     indexes={
 *         @ORM\Index(
 *             name="busca",
 *             columns={
 *                 "state_id",
 *                 "city_id",
 *                 "school_id",
 *                 "team_id"
 *             }
 *         ),
 *         @ORM\Index(
 *             name="city_group",
 *             columns={
 *                 "state_id",
 *                 "city_group_id"
 *             }
 *         )
 *     }
 * )
 * @ORM\Entity
 */
class DimRegionalAggregation
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="state_id", type="integer", nullable=true)
     */
    private $stateId;

    /**
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;

    /**
     * @ORM\Column(name="school_id", type="integer", nullable=true)
     */
    private $schoolId;

    /**
     * @ORM\Column(name="team_id", type="integer", nullable=true)
     */
    private $teamId;

    /**
     * @ORM\Column(name="city_group_id", type="integer", nullable=true)
     */
    private $cityGroupId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStateId(): int
    {
        return $this->stateId;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function getSchoolId(): int
    {
        return $this->schoolId;
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    public function getCityGroupId(): int
    {
        return $this->cityGroupId;
    }
}
