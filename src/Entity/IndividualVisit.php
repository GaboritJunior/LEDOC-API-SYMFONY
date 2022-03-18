<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IndividualVisitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: IndividualVisitRepository::class)]
#[ApiResource(
    collectionOperations: ['post', 'get'],
    itemOperations: ['put','get', 'delete'],
    denormalizationContext: ['groups' => ['write:individualVisit']],
    normalizationContext: ['groups' => ['read:individualVisit']]
)]
class IndividualVisit extends Visit
{
    #[ORM\Column(type: 'date')]
    #[Groups(['read:individualVisit', 'write:individualVisit', 'read:tourVisit', 'read:patient'])]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:individualVisit', 'write:individualVisit', 'read:tourVisit', 'read:patient'])]
    private $subject;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'individualVisits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:individualVisit', 'write:individualVisit', 'read:tourVisit'])]
    private $patient;

    #[ORM\ManyToOne(targetEntity: TourVisit::class, inversedBy: 'individualVisits')]
    #[Groups(['read:individualVisit'])]
    private $tourVisit;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getTourVisit(): ?TourVisit
    {
        return $this->tourVisit;
    }

    public function setTourVisit(?TourVisit $tourVisit): self
    {
        $this->tourVisit = $tourVisit;

        return $this;
    }
}
