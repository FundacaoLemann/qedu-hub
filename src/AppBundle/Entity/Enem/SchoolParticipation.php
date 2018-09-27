<?php

namespace AppBundle\Entity\Enem;

use AppBundle\Entity\EducationEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolParticipation
 *
 * @ORM\Table(name="enem_school_participation",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_SCHOOL_PARTICIPATION", columns={"edition", "school_id"})
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_5159509AC32A47EE", columns={"school_id"})
 *     }
 * )
 * @ORM\Entity
 */
class SchoolParticipation
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
     * @ORM\Column(name="edition", type="integer", nullable=false)
     */
    private $edition;

    /**
     * @var integer
     *
     * @ORM\Column(name="participationCount", type="integer", nullable=false)
     */
    private $participationcount;

    /**
     * @var string
     *
     * @ORM\Column(name="participationRate", type="decimal", precision=5, scale=4, nullable=false)
     */
    private $participationrate;

    /**
     * @var EducationEntity
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\EducationEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="school_id", referencedColumnName="id")
     * })
     */
    private $educationEntity;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEdition(): int
    {
        return $this->edition;
    }

    public function getParticipationcount(): int
    {
        return $this->participationcount;
    }

    public function getParticipationrate(): string
    {
        return $this->participationrate;
    }

    public function getEducationEntity(): EducationEntity
    {
        return $this->educationEntity;
    }
}
