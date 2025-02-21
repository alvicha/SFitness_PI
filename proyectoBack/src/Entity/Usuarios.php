<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
#[ApiResource]
class Usuarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $rol = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_registro = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto_perfil = null;

    #[ORM\OneToMany(targetEntity: Clases::class, mappedBy: 'entrenador')]
    private Collection $clases;

    #[ORM\ManyToMany(targetEntity: Clases::class, mappedBy: 'usuarios_apuntados')]
    private Collection $clases_apuntadas;

    public function __construct()
    {
        $this->fecha_registro = new \DateTime();
        $this->clases = new ArrayCollection();
        $this->clases_apuntadas = new ArrayCollection();
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): static
    {
        $this->rol = $rol;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;
        return $this;
    }

    public function setFotoPerfil(?string $foto_perfil): static
    {
        $this->foto_perfil = $foto_perfil;
        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->foto_perfil;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getClases(): Collection
    {
        return $this->clases;
    }

    public function getClasesApuntadas(): Collection
    {
        return $this->clases_apuntadas;
    }

    public function addClasesApuntada(Clases $clase): static
    {
        if (!$this->clases_apuntadas->contains($clase)) {
            $this->clases_apuntadas->add($clase);
            $clase->addUsuarioApuntado($this);
        }
        return $this;
    }

    public function removeClasesApuntada(Clases $clase): static
    {
        if ($this->clases_apuntadas->removeElement($clase)) {
            $clase->removeUsuarioApuntado($this);
        }
        return $this;

    }


    public function comprobar($password)
    {
        return password_verify($password, $this->password);
    }


}


