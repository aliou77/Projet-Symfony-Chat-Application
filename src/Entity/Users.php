<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fname = null;

    #[ORM\Column(length: 255)]
    private ?string $lname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'sender_id', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\ManyToMany(targetEntity: UsersBlocked::class, mappedBy: 'user_bloking_id')]
    private Collection $usersBlockeds;

    #[ORM\ManyToMany(targetEntity: UsersDeleted::class, mappedBy: 'user_deleting_id')]
    private Collection $usersDeleteds;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->usersBlockeds = new ArrayCollection();
        $this->usersDeleteds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSenderId($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSenderId() === $this) {
                $message->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsersBlocked>
     */
    public function getUsersBlockeds(): Collection
    {
        return $this->usersBlockeds;
    }

    public function addUsersBlocked(UsersBlocked $usersBlocked): self
    {
        if (!$this->usersBlockeds->contains($usersBlocked)) {
            $this->usersBlockeds->add($usersBlocked);
            $usersBlocked->addUserBlokingId($this);
        }

        return $this;
    }

    public function removeUsersBlocked(UsersBlocked $usersBlocked): self
    {
        if ($this->usersBlockeds->removeElement($usersBlocked)) {
            $usersBlocked->removeUserBlokingId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UsersDeleted>
     */
    public function getUsersDeleteds(): Collection
    {
        return $this->usersDeleteds;
    }

    public function addUsersDeleted(UsersDeleted $usersDeleted): self
    {
        if (!$this->usersDeleteds->contains($usersDeleted)) {
            $this->usersDeleteds->add($usersDeleted);
            $usersDeleted->addUserDeletingId($this);
        }

        return $this;
    }

    public function removeUsersDeleted(UsersDeleted $usersDeleted): self
    {
        if ($this->usersDeleteds->removeElement($usersDeleted)) {
            $usersDeleted->removeUserDeletingId($this);
        }

        return $this;
    }
}
