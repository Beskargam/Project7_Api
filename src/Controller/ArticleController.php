<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/api", name="api_"))
 */
class ArticleController extends AbstractController
{
    /**
     * @Rest\Get("/articles", name="article_list")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"list"})
     */
    public function list()
    {
        $response = $this->get('csa_guzzle.client.github_api')
            ->get($this->getParameter('http://localhost:8000/api').'/articles',
                [
                    'headers' => ['Authorization' => 'Bearer '.$this->getUser()->getUsername()]
                ]);

        $articles = $this->get('serializer')->deserialize($response->getBody()->getContents(), 'array', 'json');

        return $articles;
    }

    /**
     * @Rest\Get("/articles/{id<\d+>}", name="article_show")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     */
    public function show(Article $article)
    {
        return $article;
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
