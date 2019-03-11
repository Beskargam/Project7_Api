<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "api_article_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute="true"
 *      )
 * )
 *
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())")
 * )
 */
class Article
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
    private $name;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Groups({"detail"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer", inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $manufacturer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
}
