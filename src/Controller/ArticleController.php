<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/api", name="api_"))
 */
class ArticleController extends AbstractController
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @Rest\Get("/articles", name="article_list")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"list"})
     */
    public function list(ArticleRepository $articleRepository,
                         SerializerInterface $serializer)
    {
        $articles = $serializer->serialize($articleRepository
            ->findAll(), 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($articles);
    }

    /**
     * @Rest\Get("/articles/{id<\d+>}", name="article_show")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     */
    public function show(Article $article,
                         SerializerInterface $serializer)
    {
        $article = $serializer->serialize($article, 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($article);
    }

    /**
     * @Rest\Post("/articles", name="article_create")
     *
     * @Rest\View(statusCode=201)
     * @ParamConverter("article", converter="fos_rest.request_body")
     */
    public function create(EntityManagerInterface $manager,
                           Article $article)
    {
        $manager->persist($article);
        $manager->flush();

        return $article;
    }
}
