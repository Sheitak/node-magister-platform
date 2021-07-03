<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=App\Repository\CryptocurrencyRepository::class)
 * @Vich\Uploadable
 */
class Cryptocurrency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min=3, max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $consensus;

    /**
     * @ORM\Column(type="integer")
     */
    private $collateral;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticker;

    /**
     * @Vich\UploadableField(mapping="cryptocurrency_image", fileNameProperty="fileName")
     * @Assert\Image(mimeTypes="image/png")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Masternode::class, mappedBy="cryptocurrency", cascade={"persist", "remove"})
     */
    private $masternodes;

    public function __construct()
    {
        $this->masternodes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getConsensus(): ?string
    {
        return $this->consensus;
    }

    public function setConsensus(string $consensus): self
    {
        $this->consensus = $consensus;

        return $this;
    }

    public function getCollateral(): ?int
    {
        return $this->collateral;
    }

    public function setCollateral(int $collateral): self
    {
        $this->collateral = $collateral;

        return $this;
    }

    public function getFormattedCollateral(): string
    {
        return number_format($this->collateral, 0, '', ' ');
    }

    /**
     * @return Collection|Masternode[]
     */
    public function getMasternodes(): Collection
    {
        return $this->masternodes;
    }

    /**
     * @param Masternode $masternode
     * @return Cryptocurrency
     */
    public function addMasternode(Masternode $masternode): self
    {
        if (!$this->masternodes->contains($masternode)) {
            $this->masternodes[] = $masternode;
            $masternode->setCryptocurrency($this);
        }
        return $this;
    }

    public function removeMasternode(Masternode $masternode): self
    {
        if ($this->masternodes->contains($masternode)) {
            $this->masternodes->removeElement($masternode);
            // set the owning side to null (unless already changed)
            if ($masternode->getCryptocurrency() === $this) {
                $masternode->setCryptocurrency(null);
            }
        }
        return $this;
    }

    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    public function setTicker(string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Cryptocurrency
     */
    public function setImageFile(?File $imageFile): Cryptocurrency
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * @return  string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     * @return Cryptocurrency
     */
    public function setFileName(?string $fileName): Cryptocurrency
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
