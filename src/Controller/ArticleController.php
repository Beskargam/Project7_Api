<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use GuzzleHttp\Client;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Rest\Route("/api", name="api_"))
 */
class ArticleController
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
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of the articles",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Article::class, groups={"list"}))
     *     )
     * )
     * @SWG\Tag(name="articles")
     */
    public function list(ArticleRepository $articleRepository,
                         SerializerInterface $serializer,
                         UserInterface $user)
    {
        /*
        $accessTokenTime = $user->getAccessToken()->getDateToken();
        $nowTime = new \DateTime('NOW');

        if (($nowTime - $accessTokenTime) > 3600) {
            $data = [
                'message' => 'Votre Token est trop vieux vous devez en redemander un',
            ];

            return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
        }
        */

        $articles = $serializer->serialize($articleRepository
            ->findAll(), 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($articles);
    }

    /**
     * @Rest\Get("/articles/{id<\d+>}", name="article_show")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the article depending on the parameter 'Id'",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Article::class, groups={"detail"}))
     *     )
     * )
     * @SWG\Tag(name="articles")
     */
    public function show(Article $article,
                         SerializerInterface $serializer,
                         UserInterface $user)
    {
        $article = $serializer->serialize($article, 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($article);
    }

    /**
     * @Rest\Post("/articles", name="article_create")
     *
     * @Rest\View(statusCode=201)
     * @ParamConverter("article", converter="fos_rest.request_body")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Create a new article",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Items(ref=@Model(type=Article::class, groups={"detail"}))
     *     )
     * )
     * @SWG\Tag(name="articles")
     */
    public function create(EntityManagerInterface $manager,
                           Article $article,
                           UserInterface $user)
    {
        $manager->persist($article);
        $manager->flush();

        return $article;
    }
}
