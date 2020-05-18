<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(
 * fields = {"nom"},
 * message = "nom existe deja ")
 */
class Users implements UserInterface
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8" ,minMessage="Minimum 8 carr pour le password" )
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password",message="Les password sont pas identiques")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

  

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
    
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getSalt() {}
    public function eraseCredentials() {}  
    public function getRoles(){
        return ['role'];
    }
    public function getUsername(){
        return $this->nom;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }


   
}
