<?php

namespace Webit\Bundle\SmsApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WebitSmsApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
