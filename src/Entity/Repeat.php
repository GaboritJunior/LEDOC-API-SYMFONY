<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RepeatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RepeatRepository::class)]
#[ORM\Table(name: '`repeat`')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    denormalizationContext:['groups' => ['write:repeat']],
    normalizationContext:['groups' => ['repeat']]
)]
class Repeat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['repeat'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['repeat', 'read:treatment'])]
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
