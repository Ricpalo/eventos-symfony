<?php

namespace InvitadosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EventosBundle\Entity\Eventos;

/**
 * Invitados
 *
 * @ORM\Table(name="invitados")
 * @ORM\Entity(repositoryClass="InvitadosBundle\Repository\InvitadosRepository")
 */
class Invitados
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
     * @ORM\ManyToOne(targetEntity="EventosBundle\Entity\Eventos", inversedBy="invitados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evento;

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
     * @return Invitados
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
     *
     * @return Eventos
     */
    public function getEvento()
    {
        return $this->evento;
    }

    public function setEvento(Eventos $evento = null)
    {
        $this->evento = $evento;
    }

    public function __toString() {
        return $this->nombre;
    }
}
