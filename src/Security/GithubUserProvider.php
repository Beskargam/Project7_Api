<?php

namespace App\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class GithubUserProvider implements UserProviderInterface
{
    private $client;

    public function __construct(Client $client,
                                SerializerInterface $serializer,
                                EncoderInterface $encoder,
                                EntityManagerInterface $manager)
    {
        $this->client = $client;
        $this->serialzer = $serializer;
        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $code The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($code)
    {
        $response = sprintf('https://github.com/login/oauth/access_token?client_id=%s&client_secret=%s&code=%s&redirect_uri=%s',
            '5b87e9f662c9419b68c6',
            'cc4dbcdc6727f916c6eb60231929e694e7f9f04e',
            $code,
            urlencode("http://localhost:8000/api/connexion/verification")
        );
        $body = $this->client->post($response)->getBody()->getContents();

        $tab = explode("=", $body);
        $token = explode("&", $tab[1]);
        $token = $token[0];

        $url = 'https://api.github.com/user?access_token=' . $token;
        $userData = $this->client->get($url)->getBody()->getContents();

        if (!$userData) {
            throw new \LogicException('Did not managed to get your user info from Github.');
        }

        $serializedData = $this->serialzer->deserialize($userData, 'array', 'json');

        $user = new User(
            $serializedData['email'],
            $serializedData['login'],
            ['ROLE_USER'],
            $token
        );
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}