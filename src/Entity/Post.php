<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository", repositoryClass=PostRepository::class)
 * @ORM\Table(name="posts")
 */
class Post implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updated_at;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private User $author;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="postCollections")
     */
    private $categoryCollection;

    /**
     *
     * @ORM\OneToMany(targetEntity="Coment", mappedBy="post")
     */
    private $commentsCollection;

    public function __construct()
    {
        $this->categoryCollection = new ArrayCollection();
        $this->commentsCollection = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Post
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Post
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Post
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     * @return Post
     */
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     * @return Post
     */
    public function setUpdatedAt($updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Post
     */
    public function setAuthor(User $author): Post
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategoryCollection(): ?ArrayCollection
    {
        return $this->categoryCollection;
    }

    /**
     * @param ArrayCollection $categoryCollection
     * @return Post
     */
    public function setCategoryCollection(ArrayCollection $categoryCollection): Post
    {
        $this->categoryCollection = $categoryCollection;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCommentsCollection(): ?ArrayCollection
    {
        return $this->commentsCollection;
    }

    /**
     * @param ArrayCollection $commentsCollection
     */
    public function setCommentsCollection(ArrayCollection $commentsCollection): void
    {
        $this->commentsCollection = $commentsCollection;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "content" => $this->getContent(),
            "slug" => $this->getSlug(),
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt()
        ];
    }
}
