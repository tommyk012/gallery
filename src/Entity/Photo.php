<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $uploaded_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_public;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getUploadetAt(): ?\DateTimeImmutable
    {
        return $this->uploaded_at;
    }

    public function setUploadetAt(\DateTimeImmutable $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): self
    {
        $this->is_public = $is_public;

        return $this;
    }
}
