<?php

namespace AppBundle\Entity\Enem;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnemSchoolResults
 *
 * @ORM\Table(name="enem_school_results",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_C08EF8889E8F7F4E", columns={"schoolParticipation_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Enem\EnemSchoolResultsRepository")
 */
class EnemSchoolResults
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
    private $languagesAndCodesAverage;

    /**
     * @var string
     *
     * @ORM\Column(name="averageMt", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $mathematicsAverage;

    /**
     * @var string
     *
     * @ORM\Column(name="averageCh", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $humanSciencesAverage;

    /**
     * @var string
     *
     * @ORM\Column(name="averageCn", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $naturalSciencesAverage;

    /**
     * @var string
     *
     * @ORM\Column(name="averageRed", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $essayAverage;

    /**
     * @var integer
     *
     * @ORM\Column(name="schoolParticipation_id", type="integer", nullable=false)
     */
    private $schoolParticipationId;

    public function getLanguagesAndCodesAverage(): string
    {
        return $this->languagesAndCodesAverage;
    }

    public function getMathematicsAverage(): string
    {
        return $this->mathematicsAverage;
    }

    public function getHumanSciencesAverage(): string
    {
        return $this->humanSciencesAverage;
    }

    public function getNaturalSciencesAverage(): string
    {
        return $this->naturalSciencesAverage;
    }

    public function getEssayAverage(): string
    {
        return $this->essayAverage;
    }

    public function getSchoolParticipationId(): int
    {
        return $this->schoolParticipationId;
    }
}
