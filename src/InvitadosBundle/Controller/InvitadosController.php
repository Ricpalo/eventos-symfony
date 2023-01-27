<?php

namespace InvitadosBundle\Controller;

use InvitadosBundle\Form\InvitadosFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use InvitadosBundle\Entity\Invitados;

class InvitadosController extends Controller
{
    /**
     * @Route("/get", name="invitados_list")
     * @Method({"GET"})
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $invitados = $em->getRepository('InvitadosBundle:Invitados')
            ->findAll();

        return $this->render('@Invitados/Default/index.html.twig', [
           'invitados' => $invitados
        ]);
    }

    /**
     * @Route("/new", name="new_invitado")
     */
    public function newInvitado(Request $request) {
        $form = $this->createForm(InvitadosFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugar = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);
            $em->flush();

            $this->addFlash('success', 'Invitado insertado correctamente');

            return $this->redirectToRoute('invitados_list');
        }

        return $this->render('@Invitados/Form/new.html.twig', [
            'invitadosForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_invitado")
     */
    public function updateInvitado(Request $request, Invitados $invitado) {
        $form = $this->createForm(InvitadosFormType::class, $invitado);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugar = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);
            $em->flush();

            $this->addFlash('success', 'Invitado editado correctamente');

            return $this->redirectToRoute('invitados_list');
        }

        return $this->render('@Invitados/Form/edit.html.twig', [
            'invitadosForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{nombreInvitado}", name="mostrar_invitado")
     */
    public function showInvitado($nombreInvitado){
        $em = $this->getDoctrine()->getManager();
        $invitado = $em->getRepository('InvitadosBundle:Invitados')
            ->findOneBy(['nombre' => $nombreInvitado]);

        if (!$invitado) {
            throw $this->createNotFoundException('Ese invitado no existe');
        }

        return $this->render('@Invitados/Invitado/invitado.html.twig', [
           'invitado' => $invitado
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_invitado")
     */
    public function deleteInvitado($id) {
        $em = $this->getDoctrine()->getManager();
        $invitado = $em->getRepository('InvitadosBundle:Invitados')->find($id);

        if (!$invitado) {
            throw $this->createNotFoundException(
                'El invitado con ID ' . $id . ' no existe'
            );
        }

        $em->remove($invitado);
        $em->flush();

        $this->addFlash('success', 'Lugar borrado correctamente');

        return $this->redirectToRoute('invitados_list');
    }
}
