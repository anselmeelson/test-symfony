<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pourcentage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $frais;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Transfert::class, inversedBy="operations")
     */
    private $transfert;

    public function __construct(){
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?string
    {
        return $this->pourcentage;
    }

    public function setPourcentage(?string $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getFrais(): ?string
    {
        return $this->frais;
    }

    public function setFrais(?string $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTransfert(): ?Transfert
    {
        return $this->transfert;
    }

    public function setTransfert(?Transfert $transfert): self
    {
        $this->transfert = $transfert;

        return $this;
    }
}
