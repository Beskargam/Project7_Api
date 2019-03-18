<?php

namespace App\Security;


use App\Entity\Token;
use App\Entity\User;
use App\Entity\Vendor;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class GoogleUserProvider implements UserProviderInterface
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
        $response = sprintf('https://www.googleapis.com/oauth2/v4/token?code=%s&client_id=%s&client_secret=%s&redirect_uri=%s&grant_type=%s',
            $code,
            '755533673803-ilamn05m8fi64jk1hagaiidk0qjqk4u6.apps.googleusercontent.com',
            'dNcu3Ya1d5TuMSeMtTZIUzKh',
            urlencode("http://app-bilemo.herokuapp.com/api/connexion/verification"),
            'authorization_code'
        );

        $body = $this->client->post($response)->getBody()->getContents();

        $tab = explode('"', $body);
        $accessToken = explode('"', $tab[3]);
        $accessToken = $accessToken[0];

        $tab = explode('"', $body);
        $refresh_token = explode('"', $tab[9]);
        $refresh_token = $refresh_token[0];
        /*
        $tab = explode('"', $body);
        $token_type = explode('"', $tab[17]);
        $token_type = $token_type[0];
        */

        // dd($body, $accessToken, $token_type, $refresh_token);

        $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
        $userData = $this->client->get($url)->getBody()->getContents();

        if (!$userData) {
            throw new \LogicException('Did not managed to get your user info from Google.');
        }

        $serializedData = $this->serialzer->deserialize($userData, 'array', 'json');

        $token = new Token(
            $accessToken
        );
        $vendorName = 'TestVendor';
        $vendor = new Vendor(
            $vendorName
        );
        if (!$this->manager->getRepository(User::class)->findOneByEmail($serializedData['email'])) {
            $user = new User(
                $serializedData['email'],
                $serializedData['name'],
                ['ROLE_USER'],
                $refresh_token
            );
            $user->setAccessToken($token);
            $user->setVendor($vendor);
            $this->manager->persist($user);
        } else {
            $user = $this->manager->getRepository(User::class)->findOneByEmail($serializedData['email']);
            $user->getAccessToken()->setAccessToken($accessToken);
            $user->getAccessToken()->setDateToken(new \DateTime());
        }
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