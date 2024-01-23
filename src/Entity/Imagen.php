<?php

namespace App\Entity;

use App\Repository\ImagenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagenRepository::class)]
class Imagen
{
    const RUTA_CLIENTES_PORTFOLIO = "images/index/portfolio/";
    const RUTA_IMAGENES_GALERIA = "images/index/gallery/";
    const RUTA_CLIENTES_CLIENTES = "images/clients/";
    const RUTA_IMAGENES_SUBIDAS = "images/galeria/";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\File(
     * mimeTypes={"image/jpeg","image/png"},
     * mimeTypesMessage = "Solamente se permiten archivos jpeg o png.")
     */
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $numVisualizaciones = null;

    #[ORM\Column]
    private ?int $numLikes = null;

    #[ORM\Column]
    private ?int $numDownloads = null;

    #[ORM\ManyToOne(inversedBy: 'imagens')]
    private ?Categoria $categoria = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'imagenes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    public function __construct(string $nombre = "", string $password = "", string $descripcion = "", int $numVisualizaciones = 0, int $numLikes = 0, int $numDownloads = 0)
    {
        $this->id = null;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->descripcion = $descripcion;
        $this->numVisualizaciones = $numVisualizaciones;
        $this->numLikes = $numLikes;
        $this->numDownloads = $numDownloads;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getNumVisualizaciones(): ?int
    {
        return $this->numVisualizaciones;
    }

    public function setNumVisualizaciones(int $numVisualizaciones): static
    {
        $this->numVisualizaciones = $numVisualizaciones;

        return $this;
    }

    public function getNumLikes(): ?int
    {
        return $this->numLikes;
    }

    public function setNumLikes(int $numLikes): static
    {
        $this->numLikes = $numLikes;

        return $this;
    }

    public function getNumDownloads(): ?int
    {
        return $this->numDownloads;
    }

    public function setNumDownloads(int $numDownloads): static
    {
        $this->numDownloads = $numDownloads;

        return $this;
    }

    public function getUrlPortfolio(): string
    {
        return self::RUTA_CLIENTES_PORTFOLIO . $this->getNombre();
    }

    public function getUrlGallery(): string
    {
        return self::RUTA_IMAGENES_SUBIDAS . $this->getNombre();
    }

    public function getUrlClientes(): string
    {
        return self::RUTA_CLIENTES_CLIENTES . $this->getNombre();
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
