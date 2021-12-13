<?php

namespace App\Entity;

use App\Repository\UserClientRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserClientRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'e-mail que vous avez indiqué est déjà utilisé!"
 * )
 */
class UserClient implements \Symfony\Component\Security\Core\User\UserInterface, \Serializable
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $device;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    private $cfrm_password;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="user_client")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=Transfert::class, mappedBy="user_client")
     */
    private $transferts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role_user;

    public function __construct() {
        $this->created_at = new DateTime();
        $this->transactions = new ArrayCollection();
        $this->datetime = new ArrayCollection();
        $this->transferts = new ArrayCollection();
        $this->role_user = 'ROLE_ADMIN';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateAt(): ?\DateTime
    {
        return $this->date_at;
    }

    public function setDateAt(\DateTimeInterface $date_at): self
    {
        $this->date_at = $date_at;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $date_at): self
    {
        $this->created_at = $date_at;

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

    public function getCfrmPassword(): ?string
    {
        return $this->cfrm_password;
    }

    public function setCfrmPassword(string $cfrm_password): self
    {
        $this->cfrm_password = $cfrm_password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [$this->getRoleUser()];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->nom,
            $this->prenom,
            $this->date_at,
            $this->profession,
            $this->password,
            $this->device,
            $this->pays,
            $this->numero,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->nom,
            $this->prenom,
            $this->date_at,
            $this->profession,
            $this->password,
            $this->device,
            $this->pays,
            $this->numero,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUserClient($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUserClient() === $this) {
                $transaction->setUserClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transfert[]
     */
    public function getTransferts(): Collection
    {
        return $this->transferts;
    }

    public function addTransfert(Transfert $transfert): self
    {
        if (!$this->transferts->contains($transfert)) {
            $this->transferts[] = $transfert;
            $transfert->setUserClient($this);
        }

        return $this;
    }

    public function removeTransfert(Transfert $transfert): self
    {
        if ($this->transferts->removeElement($transfert)) {
            // set the owning side to null (unless already changed)
            if ($transfert->getUserClient() === $this) {
                $transfert->setUserClient(null);
            }
        }

        return $this;
    }

    public function getRoleUser(): ?string
    {
        return $this->role_user;
    }

    public function setRoleUser(string $role_user): self
    {
        $this->role_user = $role_user;

        return $this;
    }
}
