<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    const RUTA_IMAGENES_POSTS = "images/posts/";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titulo = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 100)]
    private ?string $imagen = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Usuario $idCreador = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Juego $idJuego = null;

    #[ORM\Column]
    private ?int $numLikes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getIdCreador(): ?Usuario
    {
        return $this->idCreador;
    }

    public function setIdCreador(?Usuario $idCreador): static
    {
        $this->idCreador = $idCreador;

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

    public function getIdJuego(): ?Juego
    {
        return $this->idJuego;
    }

    public function setIdJuego(?Juego $idJuego): static
    {
        $this->idJuego = $idJuego;

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

    public function getUrlImagenPost(): string
    {
        return self::RUTA_IMAGENES_POSTS . $this->getImagen();
    }

    public function __toString(): string
    {
        return $this->getTitulo();
    }
}
