<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClasesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasesRepository::class)]
#[ApiResource]
class Clases
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacidad = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\ManyToOne(inversedBy: 'clases')]
    private ?Usuarios $id_entrenador = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ubicacion = null;

    /**
     * @var Collection<int, Usuarios>
     */
    #[ORM\ManyToMany(targetEntity: Usuarios::class, inversedBy: 'clases_apuntadas')]
    private Collection $usuarios_apuntados;

    public function __construct()
    {
        $this->usuarios_apuntados = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(?int $capacidad): static
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getIdEntrenador(): ?Usuarios
    {
        return $this->id_entrenador;
    }

    public function setIdEntrenador(?Usuarios $id_entrenador): static
    {
        $this->id_entrenador = $id_entrenador;

        return $this;
    }

    public function getUbicacion(): ?string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(?string $ubicacion): static
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * @return Collection<int, Usuarios>
     */
    public function getUsuariosApuntados(): Collection
    {
        return $this->usuarios_apuntados;
    }

    public function addUsuariosApuntado(Usuarios $usuariosApuntado): static
    {
        if (!$this->usuarios_apuntados->contains($usuariosApuntado)) {
            $this->usuarios_apuntados->add($usuariosApuntado);
        }

        return $this;
    }

    public function removeUsuariosApuntado(Usuarios $usuariosApuntado): static
    {
        $this->usuarios_apuntados->removeElement($usuariosApuntado);

        return $this;
    }

    public function addUsuario(Usuarios $usuario): void
    {
        if (!$this->usuarios_apuntados->contains($usuario)) {
            $this->usuarios_apuntados[] = $usuario;
        }
    }


}
