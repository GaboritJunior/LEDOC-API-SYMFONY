<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource(
    collectionOperations: ['get','post'],
    itemOperations: ['get','put','delete'],
    denormalizationContext:['groups' => ['write:patient']],
    normalizationContext:['groups' => ['read:patient']]
)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:patient'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:patient', 'write:patient', 'read:treatment', 'read:document', 'read:individualVisit', 'read:tourVisit'])]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:patient', 'write:patient', 'read:treatment', 'read:document', 'read:individualVisit', 'read:tourVisit'])]
    private $lastName;

    #[ORM\Column(type: 'string', length: 15)]
    #[Groups(['write:patient', 'read:patient'])]
    private $socialNumber;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['write:patient', 'read:patient'])]
    private $notes;

    #[ORM\Column(type: 'integer')]
    #[Groups(['write:patient', 'read:patient'])]
    private $height;

    #[ORM\Column(type: 'integer')]
    #[Groups(['write:patient', 'read:patient'])]
    private $weight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['write:patient', 'read:patient'])]
    private $allergies;

    #[ORM\ManyToOne(targetEntity: Gender::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write:patient', 'read:patient'])]
    private $gender;

    #[ORM\ManyToOne(targetEntity: BloodGroup::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write:patient', 'read:patient'])]
    private $bloodGroup;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Document::class, orphanRemoval: true)]
    #[Groups(['write:patient', 'read:patient'])]
    private $documents;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: IndividualVisit::class)]
    #[Groups(['write:patient', 'read:patient'])]
    private $individualVisits;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Treatment::class, orphanRemoval: true)]
    #[Groups(['write:patient', 'read:patient'])]
    private $treatments;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->individualVisits = new ArrayCollection();
        $this->treatments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSocialNumber(): ?string
    {
        return $this->socialNumber;
    }

    public function setSocialNumber(string $socialNumber): self
    {
        $this->socialNumber = $socialNumber;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBloodGroup(): ?BloodGroup
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(?BloodGroup $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setPatient($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getPatient() === $this) {
                $document->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IndividualVisit[]
     */
    public function getIndividualVisits(): Collection
    {
        return $this->individualVisits;
    }

    public function addIndividualVisit(IndividualVisit $individualVisit): self
    {
        if (!$this->individualVisits->contains($individualVisit)) {
            $this->individualVisits[] = $individualVisit;
            $individualVisit->setPatient($this);
        }

        return $this;
    }

    public function removeIndividualVisit(IndividualVisit $individualVisit): self
    {
        if ($this->individualVisits->removeElement($individualVisit)) {
            // set the owning side to null (unless already changed)
            if ($individualVisit->getPatient() === $this) {
                $individualVisit->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Treatment[]
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
            $treatment->setPatient($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            // set the owning side to null (unless already changed)
            if ($treatment->getPatient() === $this) {
                $treatment->setPatient(null);
            }
        }

        return $this;
    }
}
