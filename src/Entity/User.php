<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "api_user_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute="true"
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route(
 *          "api_user_delete",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute="true"
 *     )
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *
     * @Serializer\Groups({"detail"})
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     *
     * @Serializer\Groups({"detail"})
     */
    private $refreshToken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Token", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $accessToken;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor;

    public function __construct($email, $username, $roles, $refreshToken)
    {
        $this->email = $email;
        $this->username = $username;
        $this->roles = $roles;
        $this->refreshToken = $refreshToken;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function getAccessToken(): ?Token
    {
        return $this->accessToken;
    }

    public function setAccessToken(Token $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }
}
