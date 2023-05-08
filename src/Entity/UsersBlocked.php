<?php

namespace App\Entity;

use App\Repository\UsersBlockedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersBlockedRepository::class)]
class UsersBlocked
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'usersBlockeds')]
    private Collection $user_blocking_id;

    #[ORM\Column]
    private ?int $user_blocked_id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $blockedAt = null;

    #[ORM\Column]
    private ?bool $isBlocked = null;

    public function __construct()
    {
        $this->user_blocking_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUserBlockingId(): Collection
    {
        return $this->user_blocking_id;
    }

    public function addUserBlockingId(Users $userBlockingId): self
    {
        if (!$this->user_blocking_id->contains($userBlockingId)) {
            $this->user_blocking_id->add($userBlockingId);
        }

        return $this;
    }

    public function removeUserBlokingId(Users $userBlockingId): self
    {
        $this->user_blocking_id->removeElement($userBlockingId);

        return $this;
    }

    public function getUserBlockedId(): ?int
    {
        return $this->user_blocked_id;
    }

    public function setUserBlockedId(int $user_blocked_id): self
    {
        $this->user_blocked_id = $user_blocked_id;

        return $this;
    }

    public function getBlockedAt(): ?\DateTimeImmutable
    {
        return $this->blockedAt;
    }

    public function setBlockedAt(?\DateTimeImmutable $blockedAt): self
    {
        $this->blockedAt = $blockedAt;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }
}
