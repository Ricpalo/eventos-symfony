<?php

namespace LugaresBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lugares
 *
 * @ORM\Table(name="lugares")
 * @ORM\Entity(repositoryClass="LugaresBundle\Repository\LugaresRepository")
 */
class Lugares
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\ManyToMany(targetEntity="EventosBundle\Entity\Eventos", mappedBy="eventosLugares")
     */
    private $lugaresEventos;

    /**
     * @return ArrayCollection
     */
    public function getLugaresEventos()
    {
        return $this->lugaresEventos;
    }

    /**
     * @param ArrayCollection $lugaresEventos
     */
    public function setLugaresEventos($lugaresEventos)
    {
        $this->lugaresEventos = $lugaresEventos;
    }

    public function __construct() {
        $this->lugaresEventos = new ArrayCollection();
    }

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Lugares
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Lugares
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    public function __toString() {
        return $this->getNombre();
    }
}
