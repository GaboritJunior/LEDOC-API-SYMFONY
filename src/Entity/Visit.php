<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VisitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["individualVisit" => "IndividualVisit", "tourVisit" => "TourVisit"])]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [],
    denormalizationContext: ['groups' => ['write:visit']],
    normalizationContext: ['groups' => ['read:visit']]
)]
abstract class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:visit'])]
    private $id;

    #[ORM\Column(type: 'time')]
    #[Groups(['read:individualVisit', 'write:individualVisit', 'read:tourVisit', 'write:tourVisit'])]
    private $startTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }
}
