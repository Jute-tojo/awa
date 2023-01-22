<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pointage
 *
 * @ORM\Table(name="pointage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointageRepository")
 */
class Pointage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_arrive", type="time")
     */
    private $heureArrive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_sorti", type="time")
     */
    private $heureSorti;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pointages")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Pointage
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set heureArrive
     *
     * @param \DateTime $heureArrive
     *
     * @return Pointage
     */
    public function setHeureArrive($heureArrive)
    {
        $this->heureArrive = $heureArrive;

        return $this;
    }

    /**
     * Get heureArrive
     *
     * @return \DateTime
     */
    public function getHeureArrive()
    {
        return $this->heureArrive;
    }

    /**
     * Set heureSorti
     *
     * @param \DateTime $heureSorti
     *
     * @return Pointage
     */
    public function setHeureSorti($heureSorti)
    {
        $this->heureSorti = $heureSorti;

        return $this;
    }

    /**
     * Get heureSorti
     *
     * @return \DateTime
     */
    public function getHeureSorti()
    {
        return $this->heureSorti;
    }
}

