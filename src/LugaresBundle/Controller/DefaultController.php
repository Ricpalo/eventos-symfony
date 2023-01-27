<?php

namespace LugaresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="lugares")
     */
    public function indexAction()
    {
        return $this->render('@Lugares/Default/index.html.twig');
    }
}
