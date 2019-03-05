<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
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
     * @Rest\View(statusCode=200, SerializerGroups={"detail"})
     */
    public function delete(EntityManagerInterface $manager,
                           User $user)
    {
        $manager->remove($user);
        $manager->flush();

        $data = [
            'message' => 'Utilisateur supprimmé'
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
