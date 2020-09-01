<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private \DateTime $created_at;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updated_at;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="CategoryCollection")
     */
    private $postCollections;

    public function __construct()
    {
        $this->postCollections = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Category
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Category
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     * @return Category
     */
    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     * @return Category
     */
    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPostCollections(): ArrayCollection
    {
        return $this->postCollections;
    }

    /**
     * @param ArrayCollection $postCollections
     * @return Category
     */
    public function setPostCollections(ArrayCollection $postCollections): Category
    {
        $this->postCollections = $postCollections;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->getName()}";
    }
}
