<?php

namespace App\Entity;

use DateTime;
use App\Repository\OnlineFormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OnlineFormRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"member"}, message="Vous avez déjà une autorisation parentale à ce nom")
 */
class OnlineForm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date est obligatoire")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasAgreedPhoto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasAgreedTransportation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHasAgreedPhoto(): ?bool
    {
        return $this->hasAgreedPhoto;
    }

    public function setHasAgreedPhoto(bool $hasAgreedPhoto): self
    {
        $this->hasAgreedPhoto = $hasAgreedPhoto;

        return $this;
    }

    public function getHasAgreedTransportation(): ?bool
    {
        return $this->hasAgreedTransportation;
    }

    public function setHasAgreedTransportation(bool $hasAgreedTransportation): self
    {
        $this->hasAgreedTransportation = $hasAgreedTransportation;

        return $this;
    }

    /**
     * @Vich\UploadableField(mapping="uploads_images", fileNameProperty="imageName", size="imageSize")
     * @Assert\File(
     *     maxSize = "500k",
     *     mimeTypes = {"image/jpeg", "image/JPEG", "image/png", "image/PNG", "image/jpg", "image/JPG", "application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Seuls les formats JPEG, JPG, PNG et PDF sont acceptés"
     * )
     * @Assert\NotBlank(message="La signature est obligatoire")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
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
     * @ORM\OneToOne(targetEntity=Member::class, inversedBy="onlineForm")
     */
    private $member;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre nom ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $parentName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="onlineForms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
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

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getParentName(): ?string
    {
        return $this->parentName;
    }

    public function setParentName(string $parentName): self
    {
        $this->parentName = $parentName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
