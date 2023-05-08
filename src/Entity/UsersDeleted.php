<?php

namespace App\Entity;

use App\Repository\UsersDeletedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersDeletedRepository::class)]
class UsersDeleted
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'usersDeleteds')]
    private Collection $user_deleting_id;

    #[ORM\Column]
    private ?int $user_deleted_id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    public function __construct()
    {
        $this->user_deleting_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUserDeletingId(): Collection
    {
        return $this->user_deleting_id;
    }

    public function addUserDeletingId(Users $userDeletingId): self
    {
        if (!$this->user_deleting_id->contains($userDeletingId)) {
            $this->user_deleting_id->add($userDeletingId);
        }

        return $this;
    }

    public function removeUserDeletingId(Users $userDeletingId): self
    {
        $this->user_deleting_id->removeElement($userDeletingId);

        return $this;
    }

    public function getUserDeletedId(): ?int
    {
        return $this->user_deleted_id;
    }

    public function setUserDeletedId(int $user_deleted_id): self
    {
        $this->user_deleted_id = $user_deleted_id;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get the value of isDeleted
     */ 
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set the value of isDeleted
     *
     * @return  self
     */ 
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
