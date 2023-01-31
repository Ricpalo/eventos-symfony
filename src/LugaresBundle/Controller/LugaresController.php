<?php

namespace LugaresBundle\Controller;

use LugaresBundle\Entity\Lugares;
use LugaresBundle\Form\LugaresFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LugaresController extends Controller
{
    public function listAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $lugares = $em->getRepository('LugaresBundle:Lugares')
            ->findAll();

        return $this->render('@Lugares/Default/index.html.twig', [
            'lugares' => $lugares
        ]);
    }

    public function newLugar(Request $request) {
        $form = $this->createForm(LugaresFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugar = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);
            $em->flush();

            $this->addFlash('success', 'Lugar insertado correctamente');

            return $this->redirectToRoute('lugares_list');
        }

        return $this->render('@Lugares/Form/new.html.twig', [
            'lugaresForm' => $form->createView()
        ]);
    }

    public function updateLugar(Request $request, Lugares $lugar) {
        $form = $this->createForm(LugaresFormType::class, $lugar);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugar = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);
            $em->flush();

            $this->addFlash('success', 'Lugar editado correctamente');

            return $this->redirectToRoute('lugares_list');
        }

        return $this->render('@Lugares/Form/edit.html.twig', [
            'lugaresForm' => $form->createView()
        ]);
    }

    public function showLugar($nombreLugar) {
        $em = $this->getDoctrine()->getManager();
        $lugar = $em->getRepository('LugaresBundle:Lugares')
            ->findOneBy(['nombre' => $nombreLugar]);

        if (!$lugar) {
            throw $this->createNotFoundException('Ese lugar no existe');
        }

        return $this->render('@Lugares/Lugar/lugar.html.twig', [
           'lugar' => $lugar
        ]);
    }

    public function deleteLugar($id) {
        $em = $this->getDoctrine()->getManager();
        $lugar = $em->getRepository('LugaresBundle:Lugares')->find($id);

        if (!$lugar) {
            throw $this->createNotFoundException(
                'El lugar con ID ' . $id . ' no existe'
            );
        }

        $em->remove($lugar);
        $em->flush();

        $this->addFlash('success', 'Lugar borrado correctamente');

        return $this->redirectToRoute('lugares_list');
    }
}
