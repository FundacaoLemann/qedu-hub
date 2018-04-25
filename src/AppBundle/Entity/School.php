<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school",
 *     uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="ibge",
 *          columns={"ibge_id"}
 *     ), @ORM\UniqueConstraint(
 *          name="enem",
 *          columns={"id", "city_id", "state_id", "ibge_id"}
 *     )}, indexes={
 *      @ORM\Index(name="fk_school_dependence1", columns={"dependence_id"}),
 *      @ORM\Index(name="fk_school_localization1", columns={"localization_id"}),
 *      @ORM\Index(name="fk_school_operating_conditions1", columns={"operating_conditions_id"}),
 *      @ORM\Index(name="name", columns={"name_standard"}),
 *      @ORM\Index(name="prefix_and_name",columns={"name_prefix", "name_standard"}),
 *      @ORM\Index(name="fk_school_city1", columns={"city_id"}),
 *      @ORM\Index(name="fk_school_state1", columns={"state_id"}),
 *      @ORM\Index(name="fast_search", columns={"state_id", "city_id", "id"}),
 *      @ORM\Index(name="name_2", columns={"name"}),
 *      @ORM\Index(name="city_name", columns={"city_id", "name"}),
 *      @ORM\Index(name="Enem Average", columns={"ibge_id", "state_id", "city_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolRepository")
 */
class School
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
     * @ORM\Column(name="ibge_id", type="integer", nullable=false)
     */
    private $ibgeId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_prefix", type="string", length=30, nullable=true)
     */
    private $namePrefix;

    /**
     * @var string
     *
     * @ORM\Column(name="name_standard", type="string", length=100, nullable=true)
     */
    private $nameStandard;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=140, nullable=true)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="dependence_id", type="integer", nullable=false)
     */
    private $dependenceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="localization_id", type="integer", nullable=false)
     */
    private $localizationId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIbgeId(): int
    {
        return $this->ibgeId;
    }

    public function setIbgeId(int $ibgeId)
    {
        $this->ibgeId = $ibgeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getNamePrefix(): string
    {
        return $this->namePrefix;
    }

    public function setNamePrefix(string $namePrefix)
    {
        $this->namePrefix = $namePrefix;
    }

    public function getNameStandard(): string
    {
        return $this->nameStandard;
    }

    public function setNameStandard(string $nameStandard)
    {
        $this->nameStandard = $nameStandard;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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

}
