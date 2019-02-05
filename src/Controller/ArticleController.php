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
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

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

        return $this->redirectToRoute('api_article', [
            'id' => $article->getId()
        ]);
    }
}
