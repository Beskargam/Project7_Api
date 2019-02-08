<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/api", name="api_"))
 */
class SecurityController extends AbstractController
{
    /**
     * @Rest\Get("/connexion", name="login")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"auth"})
     */
    public function login()
    {
        return $this->redirectToRoute('api_article_list');
    }

    /**
     * @Rest\Get("/deconnexion", name="logout")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"auth"})
     */
    public function logout()
    {
    }
}
