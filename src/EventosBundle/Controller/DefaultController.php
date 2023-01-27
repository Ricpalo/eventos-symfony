<?php

namespace EventosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="eventos")
     */
    public function indexAction()
    {
        return $this->render('@Eventos/Default/index.html.twig');
    }
}
