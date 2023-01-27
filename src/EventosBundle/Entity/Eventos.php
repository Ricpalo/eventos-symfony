<?php

namespace EventosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LugaresBundle\Entity\Lugares;

/**
 * Eventos
 *
 * @ORM\Table(name="eventos")
 * @ORM\Entity(repositoryClass="EventosBundle\Repository\EventosRepository")
 */
class Eventos
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
     * @ORM\OneToMany(targetEntity="InvitadosBundle\Entity\Invitados", mappedBy="evento")
     */
    private $invitados;

    /**
     * @ORM\ManyToMany(targetEntity="LugaresBundle\Entity\Lugares", inversedBy="lugaresEventos")
     * @ORM\JoinColumn(name="eventos_lugares")
     */
    private $eventosLugares;

    /**
     * @return ArrayCollection
     */
    public function getEventosLugares()
    {
        return $this->eventosLugares;
    }

    /**
     * @param ArrayCollection $eventosLugares
     */
    public function setEventosLugares($eventosLugares)
    {
        $this->eventosLugares = $eventosLugares;
    }

    public function __construct()
    {
        $this->invitados = new ArrayCollection();
        $this->eventosLugares = new ArrayCollection();
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
     * @return Eventos
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

    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Add invitado
     *
     * @param \InvitadosBundle\Entity\Invitados $invitado
     *
     * @return Eventos
     */
    public function addInvitado(\InvitadosBundle\Entity\Invitados $invitado)
    {
        $this->invitados[] = $invitado;

        return $this;
    }

    /**
     * Remove invitado
     *
     * @param \InvitadosBundle\Entity\Invitados $invitado
     */
    public function removeInvitado(\InvitadosBundle\Entity\Invitados $invitado)
    {
        $this->invitados->removeElement($invitado);
    }

    /**
     * Get invitados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitados()
    {
        return $this->invitados;
    }

    public function addEventosLugares(Lugares $lugar) {
        if($this->eventosLugares->contains($lugar)) {
            return;
        }

        $this->eventosLugares[] = $lugar;
    }
}
