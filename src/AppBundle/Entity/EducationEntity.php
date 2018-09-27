<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EducationEntity
 *
 * @ORM\Table(name="education_entity",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="type_ibge_id", columns={"type", "ibgeId", "oldId"})
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_4626FE39989D9B62", columns={"slug"}),
 *         @ORM\Index(name="IDX_4626FE3964D218E", columns={"location_id"}),
 *         @ORM\Index(name="IDX_SEARCH_OLD_ENTITY", columns={"type", "oldId"})
 *     }
 * )
 * @ORM\Entity
 */
class EducationEntity
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
     * @ORM\Column(name="ibgeId", type="integer", nullable=true)
     */
    private $ibgeid;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=222, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shortName", type="string", length=100, nullable=false)
     */
    private $shortname;

    /**
     * @var integer
     *
     * @ORM\Column(name="oldId", type="integer", nullable=false)
     */
    private $oldid;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var EducationEntity
     *
     * @ORM\ManyToOne(targetEntity="EducationEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundleEntityRegion", mappedBy="component")
     */
    private $region;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->region = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

