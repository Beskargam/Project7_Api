<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/", name="app_"))
 */
class HomeController extends AbstractController
{
    /**
     * @Rest\Get("/", name="home")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the virtual page of the API client"
     *     )
     * )
     * @SWG\Tag(name="homepage")
     */
    public function home()
    {
        return $this->render('home/indexClient.html.twig');
    }
}
