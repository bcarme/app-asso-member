<?php

namespace App\Entity;

use App\Repository\DelegationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DelegationRepository::class)
 */
class Delegation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="giver")
     */
    private $fromMember;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="receiver")
     */
    private $toMember;

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

    public function getFromMember(): ?Member
    {
        return $this->fromMember;
    }

    public function setFromMember(?Member $fromMember): self
    {
        $this->fromMember = $fromMember;

        return $this;
    }

    public function getToMember(): ?Member
    {
        return $this->toMember;
    }

    public function setToMember(?Member $toMember): self
    {
        $this->toMember = $toMember;

        return $this;
    }
}
