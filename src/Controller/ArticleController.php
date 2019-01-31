<?php

namespace App\Controller;

use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Rest\Route("/api", name="api_"))
 */
class ArticleController extends AbstractController
{
    /**
     * @Rest\Get("/articles", name="articleList")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"list"})
     */
    public function list()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $articles;
    }

    /**
     * @Rest\Get("/articles/{id<\d+>}", name="article")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     */
    public function show(Article $article)
    {
        return $article;
    }
}
