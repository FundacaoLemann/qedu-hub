<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 *
 * @ORM\Embeddable
 */
class Services
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_rede_publica", type="boolean", nullable=true)
     */
    private $hasWaterPublicNetwork;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_poco_artesiano", type="boolean", nullable=true)
     */
    private $hasArtesianWellWater;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_cacimba", type="boolean", nullable=true)
     */
    private $hasWaterReservoir;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_fonte_rio", type="boolean", nullable=true)
     */
    private $hasWaterRiver;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_inexistente", type="boolean", nullable=true)
     */
    private $hasNotWater;

    /**
     * @var boolean
     *
     * @ORM\Column(name="energia_rede_publica", type="boolean", nullable=true)
     */
    private $hasPublicNetworkPower;

    /**
     * @var boolean
     *
     * @ORM\Column(name="energia_gerador", type="boolean", nullable=true)
     */
    private $hasGeneratorPower;

    /**
     * @var boolean
     *
     * @ORM\Column(name="energia_outros", type="boolean", nullable=true)
     */
    private $hasPowerFromOthersSources;

    /**
     * @var boolean
     *
     * @ORM\Column(name="energia_inexistente", type="boolean", nullable=true)
     */
    private $hasNotEnergy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="esgoto_rede_publica", type="boolean", nullable=true)
     */
    private $hasPublicSewerSystem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="esgoto_fossa", type="boolean", nullable=true)
     */
    private $hasSepticTank;

    /**
     * @var boolean
     *
     * @ORM\Column(name="esgoto_inexistente", type="boolean", nullable=true)
     */
    private $hasNotSewerSystem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_coleta_periodica", type="boolean", nullable=true)
     */
    private $hasPeriodicGarbageCollection;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_queima", type="boolean", nullable=true)
     */
    private $hasBurnGarbage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_joga_outra_area", type="boolean", nullable=true)
     */
    private $hasTransferGarbageToOtherArea;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_recicla", type="boolean", nullable=true)
     */
    private $hasWasteRecycling;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_enterra", type="boolean", nullable=true)
     */
    private $hasGarbageBuried;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lixo_outros", type="boolean", nullable=true)
     */
    private $hasOtherGarbageDestination;

    public function hasWaterPublicNetwork(): ?bool
    {
        return $this->hasWaterPublicNetwork;
    }

    public function hasArtesianWellWater(): ?bool
    {
        return $this->hasArtesianWellWater;
    }

    public function hasWaterReservoir(): ?bool
    {
        return $this->hasWaterReservoir;
    }

    public function hasWaterRiver(): ?bool
    {
        return $this->hasWaterRiver;
    }

    public function hasNotWater(): ?bool
    {
        return $this->hasNotWater;
    }

    public function hasPublicNetworkPower(): ?bool
    {
        return $this->hasPublicNetworkPower;
    }

    public function hasGeneratorPower(): ?bool
    {
        return $this->hasGeneratorPower;
    }

    public function hasPowerFromOthersSources(): ?bool
    {
        return $this->hasPowerFromOthersSources;
    }

    public function hasNotEnergy(): ?bool
    {
        return $this->hasNotEnergy;
    }

    public function hasPublicSewerSystem(): ?bool
    {
        return $this->hasPublicSewerSystem;
    }

    public function hasSepticTank(): ?bool
    {
        return $this->hasSepticTank;
    }

    public function hasNotSewerSystem(): ?bool
    {
        return $this->hasNotSewerSystem;
    }

    public function hasPeriodicGarbageCollection(): ?bool
    {
        return $this->hasPeriodicGarbageCollection;
    }

    public function hasBurnGarbage(): ?bool
    {
        return $this->hasBurnGarbage;
    }

    public function hasTransferGarbageToOtherArea(): ?bool
    {
        return $this->hasTransferGarbageToOtherArea;
    }

    public function hasWasteRecycling(): ?bool
    {
        return $this->hasWasteRecycling;
    }

    public function hasGarbageBuried(): ?bool
    {
        return $this->hasGarbageBuried;
    }

    public function hasOtherGarbageDestination(): ?bool
    {
        return $this->hasOtherGarbageDestination;
    }
}
