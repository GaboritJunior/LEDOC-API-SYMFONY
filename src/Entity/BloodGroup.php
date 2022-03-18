<?php

namespace App\Entity;

use App\Repository\BloodGroupRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BloodGroupRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
   // denormalizationContext:['groups' => ['write:bloodGroup']],
    normalizationContext:['groups' => ['bloodGroup']]
)]
class BloodGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['bloodGroup'])]
    private $id;

    #[ORM\Column(type: 'string', length: 4)]
    #[Groups(['bloodGroup', 'read:patient'])]
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
