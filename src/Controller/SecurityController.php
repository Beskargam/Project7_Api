<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use GuzzleHttp\Client;
use Swagger\Annotations as SWG;
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
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return an authenticated user after passing the firewalls"
     * )
     * @SWG\Tag(name="security")
     */
    public function checkLogin()
    {
        return $this->render('security/login.html.twig');
    }
}
