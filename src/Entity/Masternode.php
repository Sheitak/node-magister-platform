<?php

namespace App\Entity;

use App\Repository\MasternodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MasternodeRepository::class)
 * @UniqueEntity("tx_id")
 * @UniqueEntity("private_key")
 */
class Masternode
{
    const TXOUT = [0, 1];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $alias;

    /**
     * @ORM\Column(type="text")
     * @Assert\Ip
     */
    private $ip;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/[0-9]{4}$/", message="Your port must contain 4 digits")
     */
    private $port;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex("/[a-z0-9]$/", message="Private key must only consist upper and lower case letters or numbers")
     */
    private $private_key;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex("/[a-z0-9]$/", message="The Tx_Id must only consist of upper and lower case letters or numbers")
     */
    private $tx_id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice(choices=Masternode::TXOUT, message="The Tx_Out must be 0 or 1")
     */
    private $tx_out;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="masternodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptocurrency::class, inversedBy="masternodes", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cryptocurrency;

    public function __toString(): string
    {
        return $this->getAlias();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getPrivateKey(): ?string
    {
        return $this->private_key;
    }

    public function setPrivateKey(string $private_key): self
    {
        $this->private_key = $private_key;

        return $this;
    }

    public function getTxId(): ?string
    {
        return $this->tx_id;
    }

    public function setTxId(string $tx_id): self
    {
        $this->tx_id = $tx_id;

        return $this;
    }

    public function getTxOut(): ?int
    {
        return $this->tx_out;
    }

    public function setTxOut(int $tx_out): self
    {
        $this->tx_out = $tx_out;

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

    public function getCryptocurrency(): ?Cryptocurrency
    {
        return $this->cryptocurrency;
    }

    public function setCryptocurrency(?Cryptocurrency $cryptocurrency): self
    {
        $this->cryptocurrency = $cryptocurrency;

        return $this;
    }
}
