<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManufacturerRepository")
 */
class Manufacturer
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
    private $manufacturerName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="manufacturer")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function setManufacturerName(string $manufacturerName): self
    {
        $this->manufacturerName = $manufacturerName;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setManufacturer($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getManufacturer() === $this) {
                $article->setManufacturer(null);
            }
        }

        return $this;
    }
}
