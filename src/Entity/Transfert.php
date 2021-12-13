<?php

namespace App\Entity;

use App\Repository\TransfertRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * @ORM\Entity(repositoryClass=TransfertRepository::class)
 */
class Transfert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bank_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_swift;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity=UserClient::class, inversedBy="transferts")
     */
    private $user_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="transfert")
     */
    private $operations;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function __construct() {
        $this->created_at = new DateTime();
        $this->status = true;
        $this->ref = "LOREM";
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bank_name;
    }

    public function setBankName(string $bank_name): self
    {
        $this->bank_name = $bank_name;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getCodeSwift(): ?string
    {
        return $this->code_swift;
    }

    public function setCodeSwift(string $code_swift): self
    {
        $this->code_swift = $code_swift;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getUserClient(): ?UserClient
    {
        return $this->user_client;
    }

    public function setUserClient(?UserClient $user_client): self
    {
        $this->user_client = $user_client;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setTransfert($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getTransfert() === $this) {
                $operation->setTransfert(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
