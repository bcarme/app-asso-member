<?php

namespace App\Entity;

use DateTime;
use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 * @Vich\Uploadable
 */
class Worker
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
     * @Assert\NotBlank(message="Le nom est obligatoire !")
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
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(min = 8, max = 20)
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
     * @Assert\Length(min = 2, max = 10)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Il faut des chiffres uniquement") 
     * @Assert\NotBlank(message="Le code postal est obligatoire")
     */
    private $zipcode;

  /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La fonction est obligatoire !")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "La fonction ne doit pas dépasser {{ limit }} caractères de long")
     */
    private $jobtype;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workers")
     */
    private $user;

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
     * @ORM\Column(type="datetime")
     *
     * @var Datetime
     */
    private $updatedAt;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
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

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getJobtype(): ?string
    {
        return $this->jobtype;
    }

    public function setJobtype(string $jobtype): self
    {
        $this->jobtype = $jobtype;

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
