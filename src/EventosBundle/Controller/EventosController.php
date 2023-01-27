<?php

namespace EventosBundle\Controller;

use EventosBundle\Entity\Eventos;
use EventosBundle\Form\EventosFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EventosController extends Controller
{
    /**
     * @Route("/get", name="list_eventos")
     * @Method({"GET"})
     */

    public function getEventos(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $eventos = $em->getRepository('EventosBundle:Eventos')
            ->findAll();

        return $this->render('@Eventos/Default/index.html.twig', [
           'eventos' => $eventos
        ]);
    }

    /**
     * @Route("/evento/ajax")
     */
    public function ajaxAction(Request $request) {
        $eventos = $this->getDoctrine()
            ->getRepository('EventosBundle:Eventos')
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;

            foreach ($eventos as $evento) {
                $temp = array(
                    'nombre' => $evento->getName()
                );

                $jsonData[$idx++] = temp;
            }

            return new JsonResponse($jsonData);
        } else {
            return $this->render('EventosBundle:Default:index.html.twig');
        }
    }

    /**
     * @Route("/new", name="new_evento")
     */
    public function newEvento(Request $request) {
        $form = $this->createForm(EventosFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);
            $em->flush();

            $this->addFlash('success', 'Evento insertado correctamente');

            return $this->redirectToRoute('list_eventos');
        }

        return $this->render('@Eventos/Form/new.html.twig', [
           'eventosForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_evento")
     */
    public function updateEvento(Request $request, Eventos $evento) {
        $form = $this->createForm(EventosFormType::class, $evento);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);
            $em->flush();

            $this->addFlash('success', 'Evento editado correctamente');

            return $this->redirectToRoute('list_eventos');
        }

        return $this->render('@Eventos/Form/edit.html.twig', [
            'eventosForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{nombreEvento}", name="mostrar_evento")
     */
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

    /**
     * @Route("/delete/{id}", name="delete_evento")
     */
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

        return $this->redirectToRoute('list_eventos');
    }

    /**
     * @Route("/descripcion/{id}", name="mostrar_evento_descripcion")
     */
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
}
