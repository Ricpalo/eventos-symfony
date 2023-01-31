<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class DefaultController extends Controller
{
    public function indexAction(Request $request, TranslatorInterface $translator)
    {
        return $this->render('@App/Default/index.html.twig');
    }
}