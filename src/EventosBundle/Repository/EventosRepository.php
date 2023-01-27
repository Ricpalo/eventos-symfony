<?php

namespace EventosBundle\Repository;

use EventosBundle\Entity\Eventos;

/**
 * EventosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventosRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllGuestsForEvent(Eventos $evento) {
        return $this->createQueryBuilder('eventos')
            ->select('e', 'l', 'i')
            ->from('EventosBundle:Eventos', 'e')
            ->leftJoin('e.eventosLugares', 'l')
            ->leftJoin('e.invitados', 'i')
            ->where('e.id = :id')
            ->setParameter('id', $evento->getId())
            ->getQuery()
            ->execute();
    }
}
