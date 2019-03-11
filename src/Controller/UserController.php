<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/api", name="api_"))
 */
class UserController extends AbstractController
{
    /**
     * @Rest\Get("/users", name="user_list")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"list"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of the users",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=User::class, groups={"list"}))
     *     )
     * )
     * @SWG\Tag(name="users")
     */
    public function list(UserRepository $userRepository,
                         SerializerInterface $serializer)
    {
        $users = $serializer->serialize($userRepository
            ->findAll(), 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($users);
    }

    /**
     * @Rest\Get("/users/{id<\d+>}", name="user_show")
     *
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the user depending on the parameter 'Id'",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=User::class, groups={"detail"}))
     *     )
     * )
     * @SWG\Tag(name="users")
     */
    public function show(User $user,
                         SerializerInterface $serializer)
    {
        $user = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());

        return new Response($user);
    }

    /**
     * @Rest\Delete("/users/{id<\d+>}", name="user_delete")
     *
     * @Rest\View(statusCode=204, SerializerGroups={"detail"})
     *
     * @SWG\Response(
     *     response=204,
     *     description="Delete the user depending on the parameter 'Id'",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Items(ref=@Model(type=User::class, groups={"detail"}))
     *     )
     * )
     * @SWG\Tag(name="users")
     */
    public function delete(EntityManagerInterface $manager,
                           User $user)
    {
        $manager->remove($user);
        $manager->flush();

        return null;
    }
}
