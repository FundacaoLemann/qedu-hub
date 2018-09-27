<?php

namespace AppBundle\Entity\Enem;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolResults
 *
 * @ORM\Table(name="enem_school_results",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_C08EF8889E8F7F4E", columns={"schoolParticipation_id"})
 *     }
 * )
 * @ORM\Entity
 */
class SchoolResults
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
     * @var string
     *
     * @ORM\Column(name="averageLc", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $averageLc;

    /**
     * @var string
     *
     * @ORM\Column(name="averageMt", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $averageMt;

    /**
     * @var string
     *
     * @ORM\Column(name="averageCh", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $averageCh;

    /**
     * @var string
     *
     * @ORM\Column(name="averageCn", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $averageCn;

    /**
     * @var string
     *
     * @ORM\Column(name="averageRed", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $averageRed;

    /**
     * @var \AppBundle\Entity\Enem\SchoolParticipation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enem\SchoolParticipation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="schoolParticipation_id", referencedColumnName="id")
     * })
     */
    private $schoolParticipation;
}
