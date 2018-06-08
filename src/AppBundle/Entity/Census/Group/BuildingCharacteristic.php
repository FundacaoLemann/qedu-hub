<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuildingCharacteristic
 *
 * @ORM\Embeddable
 */
class BuildingCharacteristic
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="sanitario_dentro_predio", type="boolean", nullable=true)
     */
    private $hasToiletInside;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sanitario_fora_predio", type="boolean", nullable=true)
     */
    private $hasToiletOutside;

    /**
     * @var boolean
     *
     * @ORM\Column(name="biblioteca", type="boolean", nullable=true)
     */
    private $hasLibrary;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cozinha", type="boolean", nullable=true)
     */
    private $hasKitchen;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lab_informatica", type="boolean", nullable=true)
     */
    private $hasComputerLab;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lab_ciencias", type="boolean", nullable=true)
     */
    private $hasScienceLab;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sala_leitura", type="boolean", nullable=true)
     */
    private $hasReadingRoom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="quadra_esportes", type="boolean", nullable=true)
     */
    private $hasSportsCourt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sala_diretora", type="boolean", nullable=true)
     */
    private $hasBoardRoom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sala_professores", type="boolean", nullable=true)
     */
    private $hasTeachersRoom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sala_atendimento_especial", type="boolean", nullable=true)
     */
    private $hasRoomServiceSpecial;

    public function hasToiletInside(): ?bool
    {
        return $this->hasToiletInside;
    }

    public function hasToiletOutside(): ?bool
    {
        return $this->hasToiletOutside;
    }

    public function hasLibrary(): ?bool
    {
        return $this->hasLibrary;
    }

    public function hasKitchen(): ?bool
    {
        return $this->hasKitchen;
    }

    public function hasComputerLab(): ?bool
    {
        return $this->hasComputerLab;
    }

    public function hasScienceLab(): ?bool
    {
        return $this->hasScienceLab;
    }

    public function hasReadingRoom(): ?bool
    {
        return $this->hasReadingRoom;
    }

    public function hasSportsCourt(): ?bool
    {
        return $this->hasSportsCourt;
    }

    public function hasBoardRoom(): ?bool
    {
        return $this->hasBoardRoom;
    }

    public function hasTeachersRoom(): ?bool
    {
        return $this->hasTeachersRoom;
    }

    public function hasRoomServiceSpecial(): ?bool
    {
        return $this->hasRoomServiceSpecial;
    }
}
