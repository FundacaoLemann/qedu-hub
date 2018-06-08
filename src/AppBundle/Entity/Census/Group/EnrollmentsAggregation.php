<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnrollmentsAggregation
 *
 * @ORM\Embeddable
 */
class EnrollmentsAggregation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_creche", type="smallint", nullable=true)
     */
    private $nurseryEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_pre_escolar", type="smallint", nullable=true)
     */
    private $preSchoolEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_anos_iniciais", type="smallint", nullable=true)
     */
    private $elementaryEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_anos_finais", type="smallint", nullable=true)
     */
    private $middleEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_ensino_medio", type="smallint", nullable=true)
     */
    private $highSchoolEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_eja", type="smallint", nullable=true)
     */
    private $ejaEnrollments;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_educacao_especial", type="smallint", nullable=true)
     */
    private $specialEducationEnrollments;

    public function getNurseryEnrollments(): ?int
    {
        return $this->nurseryEnrollments;
    }

    public function getPreSchoolEnrollments(): ?int
    {
        return $this->preSchoolEnrollments;
    }

    public function getElementaryEnrollments(): ?int
    {
        return $this->elementaryEnrollments;
    }

    public function getMiddleEnrollments(): ?int
    {
        return $this->middleEnrollments;
    }

    public function getHighSchoolEnrollments(): ?int
    {
        return $this->highSchoolEnrollments;
    }

    public function getEjaEnrollments(): ?int
    {
        return $this->ejaEnrollments;
    }

    public function getSpecialEducationEnrollments(): ?int
    {
        return $this->specialEducationEnrollments;
    }
}
