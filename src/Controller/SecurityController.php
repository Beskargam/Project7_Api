<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/api", name="api_"))
 */
class SecurityController extends AbstractController
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @Rest\Get("/connexion/verification", name="check_login")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"auth"})
     */
    public function checkLogin()
    {
        return $this->render('security/login.html.twig');
    }
}
