<?php

namespace EventosBundle\Controller;

use EventosBundle\Entity\Eventos;
use EventosBundle\Form\EventosFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventosController extends Controller
{
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $eventos = $em->getRepository('EventosBundle:Eventos')
            ->findAll();

        return $this->render('@Eventos/Default/index.html.twig', [
           'eventos' => $eventos
        ]);
    }

    public function newEvento(Request $request) {
        $form = $this->createForm(EventosFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($evento);
            $em->flush();

            $this->addFlash('success', 'Evento insertado correctamente');

            return $this->redirectToRoute('eventos_list');
        }

        return $this->render('@Eventos/Form/new.html.twig', [
           'eventosForm' => $form->createView()
        ]);
    }

    public function updateEvento(Request $request, Eventos $evento) {
        $form = $this->createForm(EventosFormType::class, $evento);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);
            $em->flush();

            $this->addFlash('success', 'Evento editado correctamente');

            return $this->redirectToRoute('eventos_list');
        }

        return $this->render('@Eventos/Form/edit.html.twig', [
            'eventosForm' => $form->createView()
        ]);
    }

    public function showEvento($nombreEvento) {
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('EventosBundle:Eventos')
            ->findOneBy(['nombre' => $nombreEvento]);

        if (!$evento) {
            throw $this->createNotFoundException('Ese evento no existe');
        }

        return $this->render('@Eventos/Evento/evento.html.twig', [
           'evento' => $evento
        ]);
    }

    public function deleteEvento($id) {
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('EventosBundle:Eventos')->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'El evento con ID ' . $id . ' no existe'
            );
        }

        $em->remove($evento);
        $em->flush();

        $this->addFlash('success', 'Evento borrado correctamente');

        return $this->redirectToRoute('eventos_list');
    }

    public function showDescripcionEvento($id) {
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('EventosBundle:Eventos')
            ->findOneBy(['id' => $id]);

        if (!$evento) {
            throw $this->createNotFoundException('Ese evento no existe');
        }

        $descripcion = $em->getRepository('EventosBundle:Eventos')
            ->findAllGuestsForEvent($evento);

//        dump($descripcion);die;

        return $this->render('@Eventos/Evento/descripcion.html.twig', [
            'descripcion' => $descripcion,
            'evento' => $evento
        ]);
    }

    public function removeEventoLugar($evento, $lugar) {
        $em = $this->getDoctrine()->getManager();

        /** @var  $evento */
        $evento = $em->getRepository('EventosBundle:Eventos')
            ->find($evento);

        if (!$evento) {
            throw $this->createNotFoundException('Ese Evento No Existe');
        }

        /** @var  $lugar */
        $lugar = $em->getRepository('LugaresBundle:Lugares')
            ->find($lugar);

        if (!$lugar) {
            throw $this->createNotFoundException('Ese Lugar No Existe');
        }

        $evento->removeEventosLugares($lugar);
        $em->persist($evento);
        $em->flush();

        return new Response(null, 204);
    }
}
