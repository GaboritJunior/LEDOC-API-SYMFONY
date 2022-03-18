<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TourVisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TourVisitRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['put','get', 'delete'],
    denormalizationContext: ['groups' => ['write:tourVisit']],
    normalizationContext: ['groups' => ['read:tourVisit']]
)]
class TourVisit extends Visit
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:tourVisit', 'write:tourVisit'])]
    private $title;

    #[ORM\OneToMany(mappedBy: 'tourVisit', targetEntity: IndividualVisit::class)]
    #[Groups(['read:tourVisit', 'write:tourVisit'])]
    private $individualVisits;

    public function __construct()
    {
        $this->individualVisits = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $individualVisit->setTourVisit($this);
        }

        return $this;
    }

    public function removeIndividualVisit(IndividualVisit $individualVisit): self
    {
        if ($this->individualVisits->removeElement($individualVisit)) {
            // set the owning side to null (unless already changed)
            if ($individualVisit->getTourVisit() === $this) {
                $individualVisit->setTourVisit(null);
            }
        }

        return $this;
    }
}
