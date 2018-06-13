<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnrollmentsGrade
 *
 * @ORM\Embeddable
 */
class EnrollmentsGrade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_1ano", type="smallint", nullable=true)
     */
    private $grade1;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_2ano", type="smallint", nullable=true)
     */
    private $grade2;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_3ano", type="smallint", nullable=true)
     */
    private $grade3;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_4ano", type="smallint", nullable=true)
     */
    private $grade4;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_5ano", type="smallint", nullable=true)
     */
    private $grade5;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_6ano", type="smallint", nullable=true)
     */
    private $grade6;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_7ano", type="smallint", nullable=true)
     */
    private $grade7;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_8ano", type="smallint", nullable=true)
     */
    private $grade8;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_9ano", type="smallint", nullable=true)
     */
    private $grade9;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_em_1ano", type="smallint", nullable=true)
     */
    private $grade10;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_em_2ano", type="smallint", nullable=true)
     */
    private $grade11;

    /**
     * @var integer
     *
     * @ORM\Column(name="matriculas_em_3ano", type="smallint", nullable=true)
     */
    private $grade12;

    public function getGrade1(): ?int
    {
        return $this->grade1;
    }

    public function getGrade2(): ?int
    {
        return $this->grade2;
    }

    public function getGrade3(): ?int
    {
        return $this->grade3;
    }

    public function getGrade4(): ?int
    {
        return $this->grade4;
    }

    public function getGrade5(): ?int
    {
        return $this->grade5;
    }

    public function getGrade6(): ?int
    {
        return $this->grade6;
    }

    public function getGrade7(): ?int
    {
        return $this->grade7;
    }

    public function getGrade8(): ?int
    {
        return $this->grade8;
    }

    public function getGrade9(): ?int
    {
        return $this->grade9;
    }

    public function getGrade10(): ?int
    {
        return $this->grade10;
    }

    public function getGrade11(): ?int
    {
        return $this->grade11;
    }

    public function getGrade12(): ?int
    {
        return $this->grade12;
    }
}
