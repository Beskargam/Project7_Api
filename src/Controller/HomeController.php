<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/", name="app_"))
 */
class HomeController extends AbstractController
{
    /**
     * @Rest\Get("/", name="home")
     */
    public function home()
    {
        return $this->render('home/indexClient.html.twig');
    }
}
