<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
    denormalizationContext: ['groups' => ['write:document']],
    normalizationContext: ['groups' => ['read:document']]
)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:document'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:document', 'write:document', 'read:patient'])]
    private $name;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(['read:document', 'write:document', 'read:patient'])]
    private $extension;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read:document', 'write:document', 'read:patient'])]
    private $uploadAt;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:document', 'write:document'])]
    private $patient;

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

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getUploadAt(): ?\DateTimeInterface
    {
        return $this->uploadAt;
    }

    public function setUploadAt(\DateTimeInterface $uploadAt): self
    {
        $this->uploadAt = $uploadAt;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
