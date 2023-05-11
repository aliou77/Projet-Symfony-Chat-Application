<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[Vich\Uploadable]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Vich\UploadableField(mapping: "profile_img", fileNameProperty: "profile_img", size: "imageSize")]
    #[Assert\NotBlank()]
    #[Assert\Image(mimeTypes: ['image/jpeg', 'image/jpg'])]
    #[Assert\Image(maxSize: '2M')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5, minMessage: "Name is too short" )]
    private ?string $fname = null;

    #[ORM\Column(length: 255)]
    // #[Assert\Length(min: 5, minMessage: "Name is too short !" )]
    private ?string $lname = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email(message: "Invalid email !")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(pattern: " /^\+221[0-9]{9}/ ", message: "invalid number !")]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5, minMessage: "Password is too short !" )]
    private ?string $password = null;

    #[ORM\Column(options: ['default' => "0"])]
    private ?bool $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 50, minMessage: "Max. length: 50 !" )]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'sender_id', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\ManyToMany(targetEntity: UsersBlocked::class, mappedBy: 'user_bloking_id')]
    private Collection $usersBlockeds;

    #[ORM\ManyToMany(targetEntity: UsersDeleted::class, mappedBy: 'user_deleting_id')]
    private Collection $usersDeleteds;

    #[ORM\Column(length: 255)]
    private ?string $profile_img = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $back_img = null;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->usersBlockeds = new ArrayCollection();
        $this->usersDeleteds = new ArrayCollection();
    }

    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    public function getUserIdentifier(): string
    {
        return "";
    }
    
    public function eraseCredentials()
    {
        
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
            $usersBlocked->addUserBlockingId($this);
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

    /**
     * transforme l'objet en chaine 
     */
    public function serialize()
    {
        // on return les infos qu'on veut conserver au niveau du user
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }
    /**
     * transforme la chaine en objet 
     */
    public function unserialize(string $data_serialise)
    {
        // genraliser un user apartir des information serialiser, les rendre en objet (User)
        list(
            $this->id,
            $this->email,
            $this->password
        ) = unserialize($data_serialise, ['allow_classes' => false]); // false pour ne pas instancier les classes dans la unserialisation
    }

    public function getProfileImg(): ?string
    {
        return $this->profile_img;
    }

    public function setProfileImg(string $profile_img): self
    {
        $this->profile_img = $profile_img;

        return $this;
    }

    public function getBackImg(): ?string
    {
        return $this->back_img;
    }

    public function setBackImg(string $back_img): self
    {
        $this->back_img = $back_img;

        return $this;
    }

    /*
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
    */
   public function setImageFile(?File $imageFile = null): void
   {
       $this->imageFile = $imageFile;

       if (null !== $imageFile) {
           // It is required that at least one field changes if you are using doctrine
           // otherwise the event listeners won't be called and the file is lost
           $this->updatedAt = new \DateTimeImmutable();
       }
   }

   public function getImageFile(): ?File
   {
       return $this->imageFile;
   }

    /**
     * Get the value of imageSize
     */ 
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set the value of imageSize
     *
     * @return  self
     */ 
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
