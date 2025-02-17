<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Entity\Clases;
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

    /**
     * @var Collection<int, Progreso>
     */
    #[ORM\OneToMany(targetEntity: Progreso::class, mappedBy: 'id_miembro')]
    private Collection $progresos;

    /**
     * @var Collection<int, Clases>
     */
    #[ORM\OneToMany(targetEntity: Clases::class, mappedBy: 'id_entrenador')]
    private Collection $clases;

    /**
     * @var Collection<int, Clases>
     */
    #[ORM\ManyToMany(targetEntity: Clases::class, mappedBy: 'usuarios_apuntados')]
    private Collection $clases_apuntadas;

    /**
     * @var Collection<int, Notificaciones>
     */
    #[ORM\OneToMany(targetEntity: Notificaciones::class, mappedBy: 'id_usuario')]
    private Collection $notificaciones;

    public function __construct()
    {
        $this->fecha_registro = new \DateTime();
        $this->progresos = new ArrayCollection();
        $this->clases = new ArrayCollection();
        $this->clases_apuntadas = new ArrayCollection();
        $this->notificaciones = new ArrayCollection();
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
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
        $this->password = $password;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
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

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(\DateTimeInterface $fecha_registro): static
    {
        $this->fecha_registro = (new \DateTime())->format('Y-m-d');

    }

    public function getFotoPerfil(): ?string
    {
        return $this->foto_perfil;
    }

    public function setFotoPerfil(?string $foto_perfil): static
    {
        $this->foto_perfil = $foto_perfil;

        return $this;
    }

    /**
     * @return Collection<int, Progreso>
     */
    public function getProgresos(): Collection
    {
        return $this->progresos;
    }

    public function addProgreso(Progreso $progreso): static
    {
        if (!$this->progresos->contains($progreso)) {
            $this->progresos->add($progreso);
            $progreso->setIdMiembro($this);
        }

        return $this;
    }

    public function removeProgreso(Progreso $progreso): static
    {
        if ($this->progresos->removeElement($progreso)) {
            // set the owning side to null (unless already changed)
            if ($progreso->getIdMiembro() === $this) {
                $progreso->setIdMiembro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Clases>
     */
    public function getClases(): Collection
    {
        return $this->clases;
    }

    public function addClase(Clases $clase): static
    {
        if (!$this->clases->contains($clase)) {
            $this->clases->add($clase);
            $clase->setIdEntrenador($this);
        }

        return $this;
    }

    public function removeClase(Clases $clase): static
    {
        if ($this->clases->removeElement($clase)) {
            // set the owning side to null (unless already changed)
            if ($clase->getIdEntrenador() === $this) {
                $clase->setIdEntrenador(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Clases>
     */
    public function getClasesApuntadas(): Collection
    {
        return $this->clases_apuntadas;
    }

    public function addClasesApuntada(Clases $clasesApuntada): static
    {
        if (!$this->clases_apuntadas->contains($clasesApuntada)) {
            $this->clases_apuntadas->add($clasesApuntada);
            $clasesApuntada->addUsuariosApuntado($this);
        }

        return $this;
    }

    public function removeClasesApuntada(Clases $clasesApuntada): static
    {
        if ($this->clases_apuntadas->removeElement($clasesApuntada)) {
            $clasesApuntada->removeUsuariosApuntado($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Notificaciones>
     */
    public function getNotificaciones(): Collection
    {
        return $this->notificaciones;
    }

    public function addNotificacione(Notificaciones $notificacione): static
    {
        if (!$this->notificaciones->contains($notificacione)) {
            $this->notificaciones->add($notificacione);
            $notificacione->setIdUsuario($this);
        }

        return $this;
    }

    public function removeNotificacione(Notificaciones $notificacione): static
    {
        if ($this->notificaciones->removeElement($notificacione)) {
            // set the owning side to null (unless already changed)
            if ($notificacione->getIdUsuario() === $this) {
                $notificacione->setIdUsuario(null);
            }
        }

        return $this;
    }

}
