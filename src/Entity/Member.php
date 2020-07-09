<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MemberRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte avec cet email")
 * @Vich\Uploadable
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre prénom ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre nom ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse mail est obligatoire")
     * @Assert\Email(message="Format d'adresse invalide")
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min = 10, max = 20)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Il faut des numéros uniquement") 
     * @Assert\NotBlank(message="Le numéro de téléphone est obligatoire")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre adresse ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La ville est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre ville ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $town;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min = 5, max = 10)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Il faut des chiffres uniquement") 
     * @Assert\NotBlank(message="Le code postal est obligatoire")
     */
    private $cityCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getCityCode(): ?int
    {
        return $this->cityCode;
    }

    public function setCityCode(int $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * @Vich\UploadableField(mapping="uploads_images", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "500k",
     *     mimeTypes = {"image/jpeg", "image/JPEG", "image/png", "image/PNG", "image/jpg", "image/JPG"},
     *     mimeTypesMessage = "Seuls les formats JEPG, JPG et PNG sont acceptés"
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var Datetime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=OnlineForm::class, mappedBy="member", cascade={"persist", "remove"})
     */
    private $onlineForm;

    /**
     * @ORM\OneToMany(targetEntity=Delegation::class, mappedBy="fromMember")
     */
    private $giver;

    /**
     * @ORM\OneToMany(targetEntity=Delegation::class, mappedBy="toMember")
     */
    private $receiver;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="member")
     */
    private $documents;

    public function __construct()
    {
        $this->giver = new ArrayCollection();
        $this->receiver = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getOnlineForm(): ?OnlineForm
    {
        return $this->onlineForm;
    }

    public function setOnlineForm(?OnlineForm $onlineForm): self
    {
        $this->onlineForm = $onlineForm;

        // set (or unset) the owning side of the relation if necessary
        $newMember = null === $onlineForm ? null : $this;
        if ($onlineForm->getMember() !== $newMember) {
            $onlineForm->setMember($newMember);
        }

        return $this;
    }

    /**
     * @return Collection|Delegation[]
     */
    public function getGiver(): Collection
    {
        return $this->giver;
    }

    public function addGiver(Delegation $giver): self
    {
        if (!$this->giver->contains($giver)) {
            $this->giver[] = $giver;
            $giver->setFromMember($this);
        }

        return $this;
    }

    public function removeGiver(Delegation $giver): self
    {
        if ($this->giver->contains($giver)) {
            $this->giver->removeElement($giver);
            // set the owning side to null (unless already changed)
            if ($giver->getFromMember() === $this) {
                $giver->setFromMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Delegation[]
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(Delegation $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver[] = $receiver;
            $receiver->setToMember($this);
        }

        return $this;
    }

    public function removeReceiver(Delegation $receiver): self
    {
        if ($this->receiver->contains($receiver)) {
            $this->receiver->removeElement($receiver);
            // set the owning side to null (unless already changed)
            if ($receiver->getToMember() === $this) {
                $receiver->setToMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setMember($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getMember() === $this) {
                $document->setMember(null);
            }
        }

        return $this;
    }
}