<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Profs::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prof;

    /**
     * @ORM\ManyToMany(targetEntity=Etudiants::class, mappedBy="cours")
     */
    private $etudiants;

    /**
     * @ORM\OneToMany(targetEntity=Exos::class, mappedBy="cour", orphanRemoval=true)
     */
    private $exos;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->exos = new ArrayCollection();
    }
    public function __toString()
    {
        return strval($this->id);
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getProf(): ?Profs
    {
        return $this->prof;
    }

    public function setProf(?Profs $prof): self
    {
        $this->prof = $prof;

        return $this;
    }

    /**
     * @return Collection|Etudiants[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiants $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->addCour($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiants $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            $etudiant->removeCour($this);
        }

        return $this;
    }

    /**
     * @return Collection|Exos[]
     */
    public function getExos(): Collection
    {
        return $this->exos;
    }

    public function addExo(Exos $exo): self
    {
        if (!$this->exos->contains($exo)) {
            $this->exos[] = $exo;
            $exo->setCour($this);
        }

        return $this;
    }

    public function removeExo(Exos $exo): self
    {
        if ($this->exos->contains($exo)) {
            $this->exos->removeElement($exo);
            // set the owning side to null (unless already changed)
            if ($exo->getCour() === $this) {
                $exo->setCour(null);
            }
        }

        return $this;
    }
}
