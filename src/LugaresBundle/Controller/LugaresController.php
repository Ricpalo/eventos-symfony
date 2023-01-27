<?php

namespace LugaresBundle\Controller;

use LugaresBundle\Entity\Lugares;
use LugaresBundle\Form\LugaresFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class LugaresController extends Controller
{
    /**
     * @Route("/get", name="lugares_list")
     * @Method({"GET"})
     */
    public function listAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $lugares = $em->getRepository('LugaresBundle:Lugares')
            ->findAll();

        return $this->render('@Lugares/Default/index.html.twig', [
            'lugares' => $lugares
        ]);
    }

    /**
     * @Route("/new", name="new_lugar")
     */
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

    /**
     * @Route("/update/{id}", name="update_lugar")
     */
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

    /**
     * @Route("/{nombreLugar}", name="mostrar_lugar")
     */
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

    /**
     * @Route("/delete/{id}", name="delete_lugar")
     */
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
