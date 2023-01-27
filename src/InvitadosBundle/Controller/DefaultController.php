<?php

namespace InvitadosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="invitados")
     */
    public function indexAction()
    {
        return $this->render('@Invitados/Default/index.html.twig');
    }
}
