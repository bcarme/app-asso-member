<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 *  @Vich\Uploadable
 * @UniqueEntity(fields={"member"}, message="Vous avez déjà une attestation à ce nom")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Vich\UploadableField(mapping="uploads_images", fileNameProperty="imageName", size="imageSize")
     *@Assert\File(
     *     maxSize = "500k",
     *     mimeTypes = {"image/jpeg", "image/JPEG", "image/png", "image/PNG", "image/jpg", "image/JPG", "application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Seuls les formats JPEG, JPG, PNG et PDF sont acceptés"
     * )
     * @Assert\NotBlank(message="L'attestation médicale est obligatoire")
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
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="documents")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="documents")
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

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
