<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Rest\Route("/api", name="api_"))
 */
class ApiPortalController extends AbstractController
{
    /**
     * @Rest\Get("/", name="portal")
     *
     * @Rest\View(statusCode=200)
     */
    public function Portal()
    {
        return $this->render('api_portal/indexApi.html.twig');
    }
}
