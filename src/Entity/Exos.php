<?php

namespace App\Entity;

use App\Repository\ExosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExosRepository::class)
 */
class Exos
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
     * @ORM\ManyToOne(targetEntity=Cours::class, inversedBy="exos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cour;

    /**
     * @ORM\OneToMany(targetEntity=Instructions::class, mappedBy="exo", orphanRemoval=true ,cascade={"persist"})
     */
    private $instructions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity=Reponses::class, mappedBy="exo", orphanRemoval=true)
     */
    private $reponses;

    public function __construct()
    {
        $this->instructions = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

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

    public function getCour(): ?Cours
    {
        return $this->cour;
    }

    public function setCour(?Cours $cour): self
    {
        $this->cour = $cour;

        return $this;
    }

    /**
     * @return Collection|Instructions[]
     */
    public function getInstructions(): Collection
    {
        return $this->instructions;
    }

    public function addInstruction(Instructions $instruction): self
    {
        if (!$this->instructions->contains($instruction)) {
            $this->instructions[] = $instruction;
            $instruction->setExo($this);
        }

        return $this;
    }

    public function removeInstruction(Instructions $instruction): self
    {
        if ($this->instructions->contains($instruction)) {
            $this->instructions->removeElement($instruction);
            // set the owning side to null (unless already changed)
            if ($instruction->getExo() === $this) {
                $instruction->setExo(null);
            }
        }

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Reponses[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setExo($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getExo() === $this) {
                $reponse->setExo(null);
            }
        }

        return $this;
    }
}
