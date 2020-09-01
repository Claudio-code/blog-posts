<?php

namespace App\Entity;

use App\Repository\ComentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentRepository::class)
 */
class Coment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $enail;

    /**
     * @ORM\Column(type="text")
     */
    private string $comment;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comentsCollection")
     */
    private Post $post;

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

    public function getEnail(): ?string
    {
        return $this->enail;
    }

    public function setEnail(string $enail): self
    {
        $this->enail = $enail;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }
}
