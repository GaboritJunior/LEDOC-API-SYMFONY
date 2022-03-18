<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
#[ApiResource(
    collectionOperations: ['get','post'],
    itemOperations: ['get','put','delete'],
    denormalizationContext: ['groups' => ['write:treatment']],
    normalizationContext:['groups' => ['read:treatment']]
)]
class Treatment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:treatment'])]
    private $id;

    #[ORM\ManyToMany(targetEntity: Drug::class)]
    #[Groups(['read:treatment', 'write:treatment', 'read:patient'])]
    private $drug;

    #[ORM\ManyToMany(targetEntity: Repeat::class)]
    #[Groups(['read:treatment', 'write:treatment', 'read:patient'])]
    private $repetition;

    #[ORM\ManyToOne(targetEntity: Period::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:treatment', 'write:treatment', 'read:patient'])]
    private $duration;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'treatments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:treatment', 'write:treatment'])]
    private $patient;

    public function __construct()
    {
        $this->drug = new ArrayCollection();
        $this->repetition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Drug[]
     */
    public function getDrug(): Collection
    {
        return $this->drug;
    }

    public function addDrug(Drug $drug): self
    {
        if (!$this->drug->contains($drug)) {
            $this->drug[] = $drug;
        }

        return $this;
    }

    public function removeDrug(Drug $drug): self
    {
        $this->drug->removeElement($drug);

        return $this;
    }

    /**
     * @return Collection|Repeat[]
     */
    public function getRepetition(): Collection
    {
        return $this->repetition;
    }

    public function addRepetition(Repeat $repetition): self
    {
        if (!$this->repetition->contains($repetition)) {
            $this->repetition[] = $repetition;
        }

        return $this;
    }

    public function removeRepetition(Repeat $repetition): self
    {
        $this->repetition->removeElement($repetition);

        return $this;
    }

    public function getDuration(): ?Period
    {
        return $this->duration;
    }

    public function setDuration(?Period $duration): self
    {
        $this->duration = $duration;

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
