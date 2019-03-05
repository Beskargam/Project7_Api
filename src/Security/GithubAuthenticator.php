<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GithubAuthenticator extends AbstractGuardAuthenticator
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports(Request $request)
    {
        if ($request->query->has('code')) {
            return true;
        }
        if ($request->headers->has('authorization')) {
            return true;
        }
        return false;
    }

    public function getCredentials(Request $request)
    {
        if ($request->query->has('code')) {
            return [
                'code' => $request->query->get('code'),
                ];
        }
        if ($request->headers->has('Authorization')) {
            return [
                'Bearer' => $request->headers->get('Authorization'),
                ];
        }
        return false;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (isset($credentials['code'])) {
            $apiCode = $credentials['code'];
            return $userProvider->loadUserByUsername($apiCode);
        }

        $apiToken = $credentials['Bearer'];
        $user = $this->manager->getRepository(User::class)
            ->findOneBy([
                'apiToken' => $apiToken
            ]);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // dd($request, $token, $providerKey);
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentification requise',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
