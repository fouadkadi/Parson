<?php

namespace App\Entity;

use App\Repository\InstructionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstructionsRepository::class)
 */
class Instructions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre_vrai;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre_faux;

    /**
     * @ORM\ManyToOne(targetEntity=Exos::class, inversedBy="instructions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getOrdreVrai(): ?int
    {
        return $this->ordre_vrai;
    }

    public function setOrdreVrai(int $ordre_vrai): self
    {
        $this->ordre_vrai = $ordre_vrai;

        return $this;
    }

    public function getOrdreFaux(): ?int
    {
        return $this->ordre_faux;
    }

    public function setOrdreFaux(int $ordre_faux): self
    {
        $this->ordre_faux = $ordre_faux;

        return $this;
    }

    public function getExo(): ?Exos
    {
        return $this->exo;
    }

    public function setExo(?Exos $exo): self
    {
        $this->exo = $exo;

        return $this;
    }
}
